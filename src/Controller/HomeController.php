<?php

namespace App\Controller;

use App\Repository\SuiviRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

final class HomeController extends AbstractController
{
    #[Route('/admin/home', name: 'app_home')]
    public function index(SuiviRepository $suiviRepository, ChartBuilderInterface $chartBuilder): Response
    {
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
            'plugins' => [
                'legend' => ['position' => 'top'],
            ],
        ]);

        // 4. Passer la variable du graphique à la vue Twig
        return $this->render('home/index.html.twig', [
            'chart' => $chart,
        ]);
    }
}
