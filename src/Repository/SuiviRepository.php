<?php

namespace App\Repository;

use App\Entity\Suivi;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Suivi>
 */
class SuiviRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Suivi::class);
    }

    //    /**
    //     * @return Suivi[] Returns an array of Suivi objects
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

    //    public function findOneBySomeField($value): ?Suivi
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function getCumulsJusquaDate(\DateTimeInterface $date): array
    {
        return $this->createQueryBuilder('s')
            ->select('SUM(s.nombreMorts) as mortaliteCumulee')
            ->addSelect('SUM(s.consommationAliment) as alimentCumule')
            ->addSelect('SUM(s.consommationEau) as eauCumulee')
            ->where('s.createtAt <= :date')
            ->setParameter('date', $date)
            ->getQuery()
            ->getSingleResult();
    }
}
