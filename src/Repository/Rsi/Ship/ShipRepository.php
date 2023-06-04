<?php

namespace App\Repository\Rsi\Ship;

use App\Entity\Rsi\Ship\Ship;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use function Symfony\Component\DependencyInjection\Loader\Configurator\expr;

/**
 * @extends ServiceEntityRepository<Ship>
 *
 * @method Ship|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ship|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ship[]    findAll()
 * @method Ship[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShipRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ship::class);
    }

    /**
     * @return Ship[]
     */
    public function getShipsWithExploits(): array
    {
        return $this->createQueryBuilder('s')
                    ->addSelect('e')
                    ->leftJoin('s.exploits', 'e')
                    ->having('e >= 1')
                    ->getQuery()
                    ->getResult()
        ;
    }

    /**
     * @return Ship[]
     */
    public function getShipsWithFleetsSorted(): array
    {
        $ships = $this->createQueryBuilder('s')
                      ->addSelect('f')
                      ->leftJoin('s.fleets', 'f')
                      ->getQuery()
                      ->getResult()
        ;

        $ships = array_filter($ships,
            function (Ship $ship) {
                return $ship->getNbTotalInFleets();
            });

        uasort($ships,
            function (Ship $shipA, Ship $shipB) {
                return $shipA->getNbTotalInFleets() > $shipB->getNbTotalInFleets() ? -1 : 1;
            });

        return $ships;
    }

    /**
     * @param int $id
     * @return Ship|null
     * @throws NonUniqueResultException
     */
    public function getShipWithFleetsSorted(int $id): ?Ship
    {
        return $this->createQueryBuilder('s')
                    ->addSelect('f')
                    ->leftJoin('s.fleets', 'f')
                    ->andWhere('s.id = :id')
                    ->setParameter('id', $id)
                    ->getQuery()
                    ->getOneOrNullResult()
        ;
    }

    /**
     * @return array|string[]
     */
    public function getAllTypes(): array
    {
        $qb      = $this->createQueryBuilder('s')
                        ->select('s.type')
                        ->distinct()
        ;
        $results = $qb->getQuery()->getResult();
        return count($results) ? array_column($results, 'type') : [''];
    }

    public function add(Ship $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Ship $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Ship[] Returns an array of Ship objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Ship
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
