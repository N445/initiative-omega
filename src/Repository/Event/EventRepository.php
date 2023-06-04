<?php

namespace App\Repository\Event;

use App\Entity\Event\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @extends ServiceEntityRepository<Event>
 *
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    /**
     * @param int $id
     * @return Event|null
     * @throws NonUniqueResultException
     */
    public function getById(int $id): ?Event
    {
        return $this->createQueryBuilder('e')
                    ->addSelect('e', 'd', 'r', 't')
                    ->leftJoin('e.dates', 'd')
                    ->leftJoin('e.rrule', 'r')
                    ->leftJoin('e.type', 't')
                    ->where('e.id = :id')
                    ->setParameter('id', $id)
                    ->getQuery()
                    ->getOneOrNullResult()
        ;
    }

    /**
     * @param \DateTime|null     $dateTime
     * @param int|null           $limit
     * @param UserInterface|null $user
     * @return Event[]
     */
    public function getEventsAfterDate(
        ?\DateTime     $dateTime = null,
        ?int           $limit = 6,
        ?UserInterface $user = null
    ): array
    {
        if (!$dateTime) {
            $dateTime = new \DateTime('NOW');
        }
        $qb = $this->createQueryBuilder('e')
                   ->addSelect('d')
                   ->leftJoin('e.dates', 'd')
                   ->orderBy('e.start_at', 'ASC')
        ;
        $qb
            ->where(
                $qb->expr()->orX(
                    $qb->expr()->andX(
                        $qb->expr()->andX('e.has_rrule = false'),
                        $qb->expr()->andX('e.end_at > :now'),
                    ),
                    $qb->expr()->andX('d.end_at > :now'),
                )
            )
            ->setParameter('now', $dateTime)
        ;

        if (!$user) {
            $qb->andWhere('e.is_private = false');
        }

        return $qb->getQuery()
                  ->getResult()
        ;
    }

    public function getEventsBetweenDates(
        ?\DateTime     $dateTimeStart = null,
        ?\DateTime     $dateTimeEnd = null,
        ?int           $limit = 6,
        ?Event         $exceptEvent = null,
        ?UserInterface $user = null
    ): array
    {
        if (!$dateTimeStart) {
            $dateTimeStart = new \DateTime('-6 days');
        }
        if (!$dateTimeEnd) {
            $dateTimeEnd = new \DateTime('+6 days');
        }
        $qb = $this->createQueryBuilder('e')
                   ->addSelect('d')
                   ->leftJoin('e.dates', 'd')
                   ->orderBy('e.start_at', 'ASC')
        ;
        $qb
            ->where(
                $qb->expr()->orX(
                    $qb->expr()->andX(
                        $qb->expr()->andX('e.has_rrule = false'),
                        $qb->expr()->between('e.end_at', ':start', ':end'),
                    ),
                    $qb->expr()->between('d.end_at', ':start', ':end'),
                )
            )
            ->setParameter('start', $dateTimeStart)
            ->setParameter('end', $dateTimeEnd)
        ;

        if ($exceptEvent) {
            $qb->andWhere('e.id != :id')
               ->setParameter('id', $exceptEvent->getId())
            ;
        }

        if (!$user) {
            $qb->andWhere('e.is_private = false');
        }

        return $qb->getQuery()
                  ->getResult()
        ;
    }

    /**
     * @return Event[]
     */
    public function getFinishedEvents(): array
    {
        $dateTimeEnd = new \DateTime('now');

        $qb = $this->createQueryBuilder('e')
                   ->addSelect('d')
                   ->leftJoin('e.dates', 'd')
                   ->orderBy('e.start_at', 'ASC')
        ;

        $qb
            ->where(
                $qb->expr()->andX('e.is_finished = false'),
                $qb->expr()->orX(
                    $qb->expr()->andX(
                        $qb->expr()->andX('e.has_rrule = false'),
                        $qb->expr()->andX('e.end_at < :end'),
                    ),
                    $qb->expr()->andX('d.end_at < :end'),
                )
            )
            ->setParameter('end', $dateTimeEnd)
        ;

        return $qb->getQuery()
                  ->getResult()
        ;
    }

    public function save(Event $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Event $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Event[] Returns an array of Event objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Event
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
