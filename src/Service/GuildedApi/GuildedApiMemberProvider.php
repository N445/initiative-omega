<?php

namespace App\Service\GuildedApi;

use App\Entity\Member\Member;
use App\Entity\Member\Xp;
use App\Model\Guilded\Event;
use App\Model\Guilded\Media;
use App\Model\Guilded\Profile;
use App\Repository\Member\MemberRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * @property FilesystemAdapter $cache
 */
class GuildedApiMemberProvider extends BaseGuildedApiHelper
{
    private MemberRepository       $memberRepository;

    private EntityManagerInterface $em;

    public function __construct(
        HttpClientInterface    $guildedClient,
        MemberRepository       $memberRepository,
        EntityManagerInterface $em
    )
    {
        parent::__construct($guildedClient);
        $this->memberRepository = $memberRepository;
        $this->em               = $em;
    }


    public function importMembersxp()
    {
        if (!$this->cookies) {
            return [];
        }

        $code = 'JRXJ2abE';

        $response = $this->guildedClient->request('GET', sprintf('/api/teams/%s/members', $code), [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json',
                'Cookie'       => implode(';', $this->cookies),
            ],
        ]);

        $rawMembers = $response->toArray(false)['members'] ?? [];

        $membersIds = array_column($rawMembers, 'id');
        $members    = $this->getMembersEntities($rawMembers);

        $response = $this->guildedClient->request('POST', sprintf('/api/teams/%s/members/detail', $code), [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json',
                'Cookie'       => implode(';', $this->cookies),
            ],
            'body'    => json_encode([
                'userIds' => $membersIds,
            ]),
        ]);

        $rawMembersDetails = $response->toArray(false);

        foreach ($rawMembersDetails as $id => $rawMembersDetail) {
            if ($member = $members[$id] ?? null) {
                $member
                    ->setJoinDate(new \DateTimeImmutable($rawMembersDetail['joinDate']))
                    ->setLastOnline(new \DateTimeImmutable($rawMembersDetail['lastOnline']))
                ;

                $member->addXpData(new Xp($rawMembersDetail['teamXp']));
            }
        }

        $members = array_values($members);

        foreach ($members as $key => $member) {
            $this->em->persist($member);
            if ($key % 5 == 0) {
                $this->em->flush();
            }
        }
        $this->em->flush();

        return $members;
    }

    /**
     * @param array $rawMembers
     * @return Member[]
     */
    public function getMembersEntities(array $rawMembers): array
    {
        $memberGuildedIds = array_column($rawMembers, 'id');

        $membersEntities = [];
        foreach ($this->memberRepository->getByIds($memberGuildedIds) as $membersEntity) {
            $membersEntities[$membersEntity->getGuildedId()] = $membersEntity;
        }

        $members = [];
        foreach ($rawMembers as $rawMember) {
            if (($rawMembers['type'] ?? null) === 'bot') {
                continue;
            }
            if (array_key_exists($rawMember['id'], $membersEntities)) {
                $members[$rawMember['id']] = $membersEntities[$rawMember['id']];
                continue;
            }
            $members[$rawMember['id']] = (new Member())
                ->setGuildedId($rawMember['id'])
                ->setName($rawMember['name'])
            ;
        }
        return $members;
    }
}
