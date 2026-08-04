<?php

namespace App\Repository;

use App\Entity\Bandes;
use App\Entity\MouvementStock;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MouvementStock>
 */
class MouvementStockRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MouvementStock::class);
    }

    //    /**
    //     * @return MouvementStock[] Returns an array of MouvementStock objects
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

    //    public function findOneBySomeField($value): ?MouvementStock
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    /**
     * Calcule la consommation totale d'aliment (en kg/sacs) pour une bande
     */
    public function getConsommationTotaleParBande(Bandes $bande): float
    {
        return (float) $this->createQueryBuilder('m')
            ->select('SUM(m.quantite)')
            ->where('m.bande = :bande')
            ->andWhere('m.typeMouvement = :type')
            ->setParameter('bande', $bande)
            ->setParameter('type', MouvementStock::TYPE_SORTIE)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Calcule le coût alimentaire total dépensé pour une bande donnée
     */
    public function getCoutAlimentaireTotalParBande(Bandes $bande): float
    {
        return (float) $this->createQueryBuilder('m')
            ->select('SUM(m.quantite * a.prixUnitaire)')
            ->join('m.aliment', 'a')
            ->where('m.bande = :bande')
            ->andWhere('m.typeMouvement = :type')
            ->setParameter('bande', $bande)
            ->setParameter('type', MouvementStock::TYPE_SORTIE)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
