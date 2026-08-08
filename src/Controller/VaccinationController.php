<?php

namespace App\Controller;

use App\Entity\Vaccination;
use App\Form\VaccinationType;
use App\Repository\VaccinationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class VaccinationController extends AbstractController
{
    #[Route('/gestionnaire/vaccination/new', name: 'app_vaccination')]
    public function index(EntityManagerInterface $em, Request $request): Response
    {
        $vaccination = new Vaccination();
        
        // Date prévue par défaut : aujourd'hui
        $vaccination->setDatePrevue(new \DateTime());

        $form = $this->createForm(VaccinationType::class, $vaccination);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            // Auto-bascule du statut en "Effectué" si la date réalisée est renseignée
            if ($vaccination->getDateRealisee() !== null) {
                $vaccination->setStatut('Effectué');
            }
            $vaccination->setUser($this->getUser()); // Associer l'utilisateur connecté à la vaccination
            $em->persist($vaccination);
            $em->flush();

            $this->addFlash('success', 'La vaccination a été enregistrée dans le calendrier.');

            return $this->redirectToRoute('app_vaccination_list');
        }

        return $this->render('vaccination/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/gestionnaire/vaccination/list', name: 'app_vaccination_list', methods: ['GET'])]
    public function list(VaccinationRepository $vaccinationRepository): Response
    {
        $today = new \DateTime('today');

        // Récupération de l'ensemble du calendrier
        $vaccinations = $vaccinationRepository->findBy([], ['datePrevue' => 'ASC']);

        // Calcul des métriques pour les badges d'alerte
        $enRetard = 0;
        $aVenirAujourdhui = 0;

        foreach ($vaccinations as $v) {
            if ($v->getStatut() !== 'Effectué' && $v->getDatePrevue() < $today) {
                $enRetard++;
            } elseif ($v->getStatut() == 'Effectué' && $v->getDatePrevue() == $today) {
                $aVenirAujourdhui++;
            }
        }

        return $this->render('vaccination/list.html.twig', [
            'vaccinations' => $vaccinations,
            'enRetardCount' => $enRetard,
            'aVenirAujourdhuiCount' => $aVenirAujourdhui,
        ]);
    }

    #[Route('/{id}/valider', name: 'app_vaccination_valider', methods: ['POST'])]
    public function valider(Vaccination $vaccination, EntityManagerInterface $em): Response
    {
        $vaccination->setDateRealisee(new \DateTime());
        $vaccination->setStatut('Effectué');
        $em->flush();

        $this->addFlash('success', 'La vaccination a été marquée comme effectuée.');

        return $this->redirectToRoute('app_vaccination_index');
    }
}
