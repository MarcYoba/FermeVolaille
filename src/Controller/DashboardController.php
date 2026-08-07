<?php

namespace App\Controller;

use App\Entity\CoutSanitaire;
use App\Entity\Lot;
use App\Entity\Medicament;
use App\Entity\Sortie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard', methods: ['GET'])]
    public function index(EntityManagerInterface $em): Response
    {
        $today = new \DateTime();
        $in30Days = (new \DateTime())->modify('+30 days');

        // 1. Chiffre d'affaires total
        $chiffreAffaires = $em->createQuery(
            'SELECT SUM(c.montantBrut) FROM App\Entity\CoutSanitaire c'
        )->getSingleScalarResult() ?? '0.00';

        // 2. Nombre total de délivrances / ventes
        $totalDelivrances = $em->getRepository(Sortie::class)->count([]);

        // 3. Lots périmés dans les 30 prochains jours (stock > 0)
        $lotsBientotPerimes = $em->createQuery(
            'SELECT l FROM App\Entity\Lot l
             WHERE l.dateExpiration BETWEEN :today AND :in30Days
             AND l.quantiteEnStock > 0
             ORDER BY l.dateExpiration ASC'
        )
        ->setParameter('today', $today)
        ->setParameter('in30Days', $in30Days)
        ->setMaxResults(5)
        ->getResult();

        // 4. Nombre de lots déjà périmés non encore jetés
        $countLotsPerimes = $em->createQuery(
            'SELECT COUNT(l.id) FROM App\Entity\Lot l
             WHERE l.dateExpiration < :today
             AND l.quantiteEnStock > 0'
        )
        ->setParameter('today', $today)
        ->getSingleScalarResult();

        // 5. Produits sous le seuil d'alerte de stock
        $medicamentsAlerteStock = $em->createQuery(
            'SELECT m, SUM(l.quantiteEnStock) as HIDDEN totalStock
             FROM App\Entity\Medicament m
             LEFT JOIN m.lots l
             GROUP BY m.id
             HAVING totalStock <= 0 OR totalStock IS NULL'
        )
        ->setMaxResults(5)
        ->getResult();

        // 6. 5 Dernières transactions (Délivrances)
        $dernieresSorties = $em->getRepository(Sortie::class)->findBy([], ['dateSortie' => 'DESC'], 5);

        return $this->render('dashboard/index.html.twig', [
            'chiffreAffaires' => $chiffreAffaires,
            'totalDelivrances' => $totalDelivrances,
            'lotsBientotPerimes' => $lotsBientotPerimes,
            'countLotsPerimes' => $countLotsPerimes,
            'medicamentsAlerteStock' => $medicamentsAlerteStock,
            'dernieresSorties' => $dernieresSorties,
        ]);
    }
}
