<?php

namespace App\Repository;

use App\Entity\Location;
use App\Entity\Weatherdata;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Weatherdata>
 */
class WeatherdataRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Weatherdata::class);
    }

    public function findByLocation(Location $location)
    {
        $qb = $this->createQueryBuilder('wd');
        $qb->where('wd.location = :location')
            ->setParameter('location', $location);

        return $qb->getQuery()->getResult();
    }

    //    /**
    //     * @return Weatherdata[] Returns an array of Weatherdata objects
    //     */
    //
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('w')
    //            ->andWhere('w.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('w.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Weatherdata
    //    {
    //        return $this->createQueryBuilder('w')
    //            ->andWhere('w.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
