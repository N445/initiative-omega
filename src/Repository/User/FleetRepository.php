<?php

namespace App\Repository\User;

use App\Entity\User;
use App\Entity\User\Fleet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Fleet>
 *
 * @method Fleet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fleet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fleet[]    findAll()
 * @method Fleet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FleetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fleet::class);
    }

    public function getUserFleets(User $user)
    {
        return $this->createQueryBuilder('f')
                    ->addSelect('ship')
                    ->leftJoin('f.ship', 'ship')
                    ->andWhere('f.user = :user')
                    ->setParameter('user', $user)
                    ->orderBy('ship.name', 'ASC')
                    ->getQuery()
                    ->getResult()
        ;
    }

    public function add(Fleet $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Fleet $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Fleet[] Returns an array of Fleet objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Fleet
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
