<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Repository\SuiviRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

final class HomeController extends AbstractController
{
    #[Route('/admin/home', name: 'app_home')]
    public function index(SuiviRepository $suiviRepository, ChartBuilderInterface $chartBuilder, EntityManagerInterface $em, Request $request): Response
    {
        // 1. Détection de la WebView Android
        $isWebView = $request->headers->has('X-App-WebView') 
            || $request->headers->get('X-Requested-With') === 'com.tonentreprise.tonapp';

        // 1. Récupérer les données de suivi ordonnées par date
        $suivis = $suiviRepository->findBy([], ['createtAt' => 'ASC']);

        // 2. Extraire les étiquettes (dates/âges) et les séries de données
        $labels = [];
        $dataMorts = [];
        $dataConsommation = [];

        foreach ($suivis as $suivi) {
            $labels[] = 'Jour ' . $suivi->getAge() . ' (' . $suivi->getCreatetAt()->format('d/m') . ')';
            $dataMorts[] = $suivi->getNombreMorts();
            $dataConsommation[] = $suivi->getConsommationAliment();
        }

        // 3. Créer le graphique (Courbe / Line)
        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);

        $chart->setData([
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Mortalité (nombre)',
                    'backgroundColor' => 'rgba(220, 53, 69, 0.2)',
                    'borderColor' => 'rgb(220, 53, 69)',
                    'data' => $dataMorts,
                    'tension' => 0.3, // Courbure de la ligne
                ],
                [
                    'label' => 'Consommation Aliment (kg)',
                    'backgroundColor' => 'rgba(40, 167, 69, 0.2)',
                    'borderColor' => 'rgb(40, 167, 69)',
                    'data' => $dataConsommation,
                    'tension' => 0.3,
                ],
            ],
        ]);

        $chart->setOptions([
            'responsive' => true,
            'maintainAspectRatio' => false, // Rendu réactif optimisé pour les écrans mobiles
            'plugins' => [
                'legend' => ['position' => 'top'],
            ],
        ]);

        $today = new \DateTime();
        $in30Days = (new \DateTime())->modify('+30 days');

        // 5. Calcul des métriques KPI & Requêtes
        $chiffreAffaires = $em->createQuery(
            'SELECT SUM(c.montantBrut) FROM App\Entity\CoutSanitaire c'
        )->getSingleScalarResult() ?? '0.00';

        $totalDelivrances = $em->getRepository(Sortie::class)->count([]);

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

        $countLotsPerimes = $em->createQuery(
            'SELECT COUNT(l.id) FROM App\Entity\Lot l
             WHERE l.dateExpiration < :today
             AND l.quantiteEnStock > 0'
        )
        ->setParameter('today', $today)
        ->getSingleScalarResult();

        $medicamentsAlerteStock = $em->createQuery(
            'SELECT m, SUM(l.quantiteEnStock) as HIDDEN totalStock
             FROM App\Entity\Medicament m
             LEFT JOIN m.lots l
             GROUP BY m.id
             HAVING totalStock <= 0 OR totalStock IS NULL'
        )
        ->setMaxResults(5)
        ->getResult();

        $dernieresSorties = $em->getRepository(Sortie::class)->findBy([], ['dateSortie' => 'DESC'], 5);

        // 6. Rendu du template Twig
        return $this->render('home/index.html.twig', [
            'chart'                  => $chart,
            'chiffreAffaires'        => $chiffreAffaires,
            'totalDelivrances'       => $totalDelivrances,
            'lotsBientotPerimes'     => $lotsBientotPerimes,
            'countLotsPerimes'       => $countLotsPerimes,
            'medicamentsAlerteStock' => $medicamentsAlerteStock,
            'dernieresSorties'       => $dernieresSorties,
            'is_webview'             => $isWebView,
        ]);
    }
}
