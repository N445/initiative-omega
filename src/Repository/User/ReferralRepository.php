<?php

namespace App\Repository\User;

use App\Entity\User\Referral;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Referral>
 *
 * @method Referral|null find($id, $lockMode = null, $lockVersion = null)
 * @method Referral|null findOneBy(array $criteria, array $orderBy = null)
 * @method Referral[]    findAll()
 * @method Referral[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReferralRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Referral::class);
    }


    public function getReferralToDisplay(): ?Referral
    {
        return $this->createQueryBuilder('r')
                    ->where('r.is_enabled = :is_enabled')
                    ->setParameter('is_enabled', true)
                    ->andWhere('r.is_actual_to_display = :is_actual_to_display')
                    ->setParameter('is_actual_to_display', true)
                    ->orderBy('r.displayed_at', 'ASC')
                    ->getQuery()
                    ->getResult()[0] ?? null;
    }

    /**
     * @return Referral[]
     */
    public function getActiveReferrals(): array
    {
        return $this->createQueryBuilder('r')
                    ->where('r.is_enabled = :is_enabled')
                    ->setParameter('is_enabled', true)
                    ->orderBy('r.displayed_at', 'ASC')
                    ->getQuery()
                    ->getResult()
        ;
    }

    public function save(Referral $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Referral $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Referral[] Returns an array of Referral objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Referral
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
