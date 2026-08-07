<?php 

// src/Controller/ApprovisionnementController.php
namespace App\Controller;

use App\DTO\ApprovisionnementDTO;
use App\Entity\Achat;
use App\Entity\Entree;
use App\Entity\Fournisseur;
use App\Entity\Lot;
use App\Entity\Medicament;
use App\Form\ApprovisionnementType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApprovisionnementController extends AbstractController
{
    #[Route('/approvisionnement/nouveau', name: 'app_approvisionnement_nouveau')]
    public function nouveau(Request $request, EntityManagerInterface $em): Response
    {
        $dto = new ApprovisionnementDTO();
        $form = $this->createForm(ApprovisionnementType::class, $dto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            // 1. Gestion du Fournisseur (existant ou nouveau)
            $fournisseur = $dto->fournisseur;
            if (!$fournisseur && $dto->nouveauFournisseurNom) {
                $fournisseur = new Fournisseur();
                $fournisseur->setNomSociete($dto->nouveauFournisseurNom);
                $fournisseur->setUser($this->getUser());
                $em->persist($fournisseur);
            }

            // 2. Gestion du Médicament (existant ou nouveau)
            $medicament = $dto->medicament;
            if (!$medicament && $dto->nouveauMedicamentNom) {
                $medicament = new Medicament();
                $medicament->setNomCommercial($dto->nouveauMedicamentNom);
                $medicament->setForme($dto->forme);
                $medicament->setPrixUnitaire($dto->prixUnitaire);
                $medicament->setUser($this->getUser());
                $em->persist($medicament);
            }

            // 3. Création du Lot
            $lot = new Lot();
            $lot->setMedicament($medicament);
            $lot->setDateExpiration($dto->dateExpiration);
            $lot->setQuantiteEnStock($dto->quantite);
            $lot->setPrixAchatUnitaire($dto->prixAchatUnitaire);
            $em->persist($lot);

            // 4. Enregistrement de l'Entrée en stock
            $entree = new Entree();
            $entree->setFournisseur($fournisseur);
            $entree->setLot($lot);
            $entree->setQuantiteRecue($dto->quantite);
            $entree->setDateEntree(new \DateTime());
            $entree->setUser($this->getUser());
            $em->persist($entree);

            // 5. creation de l'achat

            $achat = new Achat();
            $achat->setCreatetAt(new \DateTime());
            $achat->setMontant($dto->prixAchatUnitaire * $dto->quantite);
            $achat->setPrix($dto->prixAchatUnitaire);
            $achat->setQuantite($dto->quantite);
            $achat->setUser($this->getUser());
            $em->persist($achat);

            // Transaction globale en BDD
            $em->flush();

            $this->addFlash('success', 'L\'approvisionnement et le lot ont été enregistrés avec succès !');

            return $this->redirectToRoute('app_approvisionnement_nouveau');
        }

        return $this->render('approvisionnement/nouveau.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/approvisionnement/list', name: 'app_approvisionnement_list', methods: ['GET'])]
    public function index(EntityManagerInterface $em): Response
    {
        // On récupère toutes les entrées triées par date récente
        $entrees = $em->getRepository(Entree::class)->findBy([], ['dateEntree' => 'DESC']);
        return $this->render('approvisionnement/list.html.twig', [
            'entrees' => $entrees,
        ]);
    }

    #[Route('/approvisionnement/{id}/detail', name: 'app_approvisionnement_show', methods: ['GET'])]
    public function show(Entree $entree): Response
    {
        return $this->render('approvisionnement/show.html.twig', [
            'entree' => $entree,
        ]);
    }
}