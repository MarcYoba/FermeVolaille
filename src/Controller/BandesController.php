<?php

namespace App\Controller;

use App\Entity\Bandes;
use App\Entity\Fermes;
use App\Repository\BandesRepository;
use App\Repository\SuiviRepository;
use App\Form\BandesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

final class BandesController extends AbstractController
{
    #[Route('/gestionnaire/bandes/create', name: 'app_bandes')]
    public function index(EntityManagerInterface $em, Request $request): Response
    {
        $bande = new Bandes();
        $form = $this->createForm(BandesType::class,$bande);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $fermes = $em->getRepository(Fermes::class)->find(1);
            $bande->setFerme($fermes);
            $bande->setUser($this->getUser());
            $bande->setCreatetAt(new \DateTime());
            $bande->setStatus("EN COUR");

            $em->persist($bande);
            $em->flush();

            return $this->redirectToRoute('app_bandes_liste');
        }
        return $this->render('bandes/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/gestionnaire/bandes/list', name: 'app_bandes_liste')]
    public function list(EntityManagerInterface $em): Response
    {
        $bandes = $em->getRepository(Bandes::class)->findAll();

        return $this->render('bandes/list.html.twig', [
            'bandes' => $bandes,
        ]);
    }

    #[Route('/admin/bandes/edit/{id}', name: 'app_bandes_edit')]
    public function edit(EntityManagerInterface $em, Request $request, int $id): Response
    {
        $bande = $em->getRepository(Bandes::class)->find($id);

        if (!$bande) {
            return $this->redirectToRoute('app_bandes_liste');
        }

        $form = $this->createForm(BandesType::class,$bande);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $fermes = $em->getRepository(Fermes::class)->find(1);
            $bande->setFerme($fermes);
            $bande->setUser($this->getUser());
            $bande->setCreatetAt(new \DateTime());
            $bande->setStatus("EN COUR");

            return $this->redirectToRoute('app_bandes_liste');
        }
        return $this->render('bandes/index.html.twig', [
            'bandes' => $bande,
        ]);
    }

    #[Route('/admin/bandes/delete/{id}', name: 'app_bandes_delete')]
    public function delete(EntityManagerInterface $em, int $id) : Response 
    {
       $bande = $em->getRepository(Bandes::class)->find($id);

        if (!$bande) {
            return $this->redirectToRoute('app_bandes_liste');
        }
        
        $em->remove($bande);
        $em->flush();

        return $this->redirectToRoute('app_bandes_liste');
    }
    #[Route('/dashboard/bande/{id?}', name: 'app_dashboard_bande')]
    public function dashboard(
        ?Bandes $bande, 
        BandesRepository $bandesRepository, 
        SuiviRepository $suiviRepository, 
        ChartBuilderInterface $chartBuilder
    ): Response {
        // 1. Récupérer toutes les bandes pour la liste déroulante de sélection
        $toutesLesBandes = $bandesRepository->findAll();

        // 2. Si aucune bande n'est précisée dans l'URL, on prend la toute première par défaut
        if (!$bande && !empty($toutesLesBandes)) {
            $bande = $toutesLesBandes[0];
        }

        $chart = null;

        // 3. Si on a une bande sélectionnée, on construit la courbe
        if ($bande) {
            // Récupère les suivis triés par âge ou par date
            $suivis = $suiviRepository->findBy(
                ['bande' => $bande], 
                ['age' => 'ASC']
            );

            $labels = [];
            $dataMorts = [];
            $dataAliment = [];
            $dataEau = [];

            foreach ($suivis as $suivi) {
                $labels[] = 'J' . $suivi->getAge() . ' (' . $suivi->getCreatetAt()->format('d/m') . ')';
                $dataMorts[] = $suivi->getNombreMorts();
                $dataAliment[] = $suivi->getConsommationAliment();
                $dataEau[] = $suivi->getConsommationEau();
            }

            // Construction du graphique
            $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
            $chart->setData([
                'labels' => $labels,
                'datasets' => [
                    [
                        'label' => 'Mortalité (sujets)',
                        'backgroundColor' => 'rgba(220, 53, 69, 0.2)',
                        'borderColor' => 'rgb(220, 53, 69)',
                        'data' => $dataMorts,
                        'yAxisID' => 'y', // Axe de gauche pour la mortalité
                    ],
                    [
                        'label' => 'Consommation Aliment (kg)',
                        'backgroundColor' => 'rgba(40, 167, 69, 0.2)',
                        'borderColor' => 'rgb(40, 167, 69)',
                        'data' => $dataAliment,
                        'yAxisID' => 'y1', // Axe de droite pour la consommation
                    ]
                ],
            ]);

            $chart->setOptions([
                'responsive' => true,
                'interaction' => ['mode' => 'index', 'intersect' => false],
                'scales' => [
                    'y' => [
                        'type' => 'linear',
                        'display' => true,
                        'position' => 'left',
                        'title' => ['display' => true, 'text' => 'Mortalité']
                    ],
                    'y1' => [
                        'type' => 'linear',
                        'display' => true,
                        'position' => 'right',
                        'grid' => ['drawOnChartArea' => false],
                        'title' => ['display' => true, 'text' => 'Aliment (kg)']
                    ],
                ]
            ]);
        }

        return $this->render('bandes/bande.html.twig', [
            'toutesLesBandes' => $toutesLesBandes,
            'bandeSelectionnee' => $bande,
            'chart' => $chart,
        ]);
    }
}
