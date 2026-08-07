<?php

namespace App\Controller;

use App\DTO\DelivranceDTO;
use App\Entity\CoutSanitaire;
use App\Entity\Sortie;
use App\Entity\Traitement;
use App\Form\DelivranceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DelivranceController extends AbstractController
{
    #[Route('/gestionnaire/delivrance/nouvelle', name: 'app_delivrance_nouvelle', methods: ['GET', 'POST'])]
    public function nouvelle(Request $request, EntityManagerInterface $em): Response
    {
        $dto = new DelivranceDTO();
        $form = $this->createForm(DelivranceType::class, $dto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lot = $dto->lot;

            // VÉRIFICATION DU STOCK DISPONIBLE
            if ($lot->getQuantiteEnStock() < $dto->quantiteSortie) {
                $this->addFlash('danger', sprintf(
                    'Stock insuffisant ! Le lot %s ne contient que %d unité(s).',
                    $lot->getId(),
                    $lot->getQuantiteEnStock()
                ));

                return $this->render('delivrance/nouvelle.html.twig', [
                    'form' => $form->createView(),
                ]);
            }

            // 1. Traitement (Existant ou nouveau)
            $traitement = $dto->traitement;
            if (!$traitement && $dto->nouveauTraitementNom) {
                $traitement = new Traitement();
                $traitement->setNomTraitement($dto->nouveauTraitementNom);
                $traitement->setDescription($dto->descriptionTraitement);
                $em->persist($traitement);
            }

            // 2. Décrémentation du stock du Lot
            $nouveauStock = $lot->getQuantiteEnStock() - $dto->quantiteSortie;
            $lot->setQuantiteEnStock($nouveauStock);

            // 3. Enregistrement de la Sortie
            $sortie = new Sortie();
            $sortie->setLot($lot);
            $sortie->setTraitement($traitement);
            $sortie->setQuantiteSortie($dto->quantiteSortie);
            $sortie->setDateSortie(new \DateTime());
            $sortie->setMotifSortie($dto->motifSortie);
            $em->persist($sortie);

        //     // 4. Enregistrement du Coût Sanitaire
        //     $cout = new CoutSanitaire();
        //     $cout->setTraitement($traitement);
        //     $cout->setSortie($sortie);
        //     $cout->setMontantBrut($dto->montantBrut);
        //    // $cout->setPartAssurances($dto->partAssurances ?? '0.00');
        //     $cout->setPartPatient($dto->partPatient ?? '0.00');
        //     //$cout->setStatutPaiement($dto->statutPaiement);
        //     $em->persist($cout);

            // Validation de la transaction globale
            $em->flush();

            $this->addFlash('success', 'La délivrance et le règlement ont été enregistrés avec succès.');

            return $this->redirectToRoute('app_delivrance_nouvelle');
        }

        return $this->render('delivrance/nouvelle.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/gestionnaire/delivrance/historique/list', name: 'app_delivrance_list', methods: ['GET'])]
    public function historique(EntityManagerInterface $em): Response
    {
        // Récupération de toutes les sorties ordonnées de la plus récente à la plus ancienne
        $sorties = $em->getRepository(Sortie::class)->findBy([], ['dateSortie' => 'DESC']);

        return $this->render('delivrance/list.html.twig', [
            'sorties' => $sorties,
        ]);
    }
}