<?php

namespace App\Repository\Member;

use App\Entity\Member\Member;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Member>
 *
 * @method Member|null find($id, $lockMode = null, $lockVersion = null)
 * @method Member|null findOneBy(array $criteria, array $orderBy = null)
 * @method Member[]    findAll()
 * @method Member[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MemberRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Member::class);
    }

    public function getLastLoggedUser(?int $limit = null)
    {
        $qb = $this->createQueryBuilder('m')
                   ->select('m.id')
        ;

        if ($limit) {
            $qb->setMaxResults($limit);
        }

        $ids = $qb->getQuery()
                  ->getResult()
        ;

        return $this->createQueryBuilder('m')
                    ->where('m.id in (:ids)')
                    ->setParameter('ids', $ids)
                    ->orderBy('m.lastOnline', 'DESC')
                    ->getQuery()
                    ->getResult()
        ;
    }

    public function getDashboardUsers()
    {
        $ids = $this->createQueryBuilder('m')
                    ->select('m.id')
                    ->where('m.isDisplayOnDashboard = true')
                    ->getQuery()
                    ->getResult()
        ;

        return $this->createQueryBuilder('m')
                    ->where('m.id in (:ids)')
                    ->setParameter('ids', $ids)
                    ->orderBy('m.lastOnline', 'DESC')
                    ->getQuery()
                    ->getResult()
        ;
    }

    /**
     * @param array $ids
     * @return Member[]
     */
    public function getByIds(array $ids): array
    {
        return $this->createQueryBuilder('m')
                    ->andWhere('m.guildedId in (:ids)')
                    ->setParameter('ids', $ids)
                    ->getQuery()
                    ->getResult()
        ;
    }

    /**
     * @param string $id
     * @return Member
     * @throws NonUniqueResultException
     */
    public function getById(string $id): Member
    {
        return $this->createQueryBuilder('m')
                    ->andWhere('m.guildedId = :id')
                    ->setParameter('id', $id)
                    ->getQuery()
                    ->getOneOrNullResult()
        ;
    }

    public function add(Member $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Member $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Member[] Returns an array of Member objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Member
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
