<?php

namespace App\Controller;

use App\Entity\FicheProduction;
use App\Entity\LigneProduction;
use App\Entity\Produit;
use App\Form\FicheProductionType;
use App\Repository\FicheProductionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/fiche/production')]
final class FicheProductionController extends AbstractController
{
    #[Route('/list', name: 'app_fiche_production_index', methods: ['GET'])]
    public function index(FicheProductionRepository $ficheProductionRepository): Response
    {
        return $this->render('fiche_production/index.html.twig', [
            'fiche_productions' => $ficheProductionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_fiche_production_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // 1. Vérification de l'utilisateur connecté
        $user = $this->getUser();
        if (!$user) {
            $this->addFlash('error', 'Vous devez être connecté pour créer une fiche de production.');
            return $this->redirectToRoute('app_login');
        }

        $ficheProduction = new FicheProduction();

        // 2. Association automatique de l'utilisateur et de la date
        $ficheProduction->setUser($user);
        // $ficheProduction->setCreatedAt(new \DateTime()); // Déjà géré dans le constructeur de l'entité

        $form = $this->createForm(FicheProductionType::class, $ficheProduction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // 3. Liaison explicite des lignes à la fiche principale (sécurité pour Cascade Persist)
            // 2. Traitement de la collection 'lignes' pour extraire le champ 'nom' non mappé
            $lignesForms = $form->get('lignes');

            foreach ($lignesForms as $ligneForm) {
                /** @var LigneProduction $ligne */
                $ligne = $ligneForm->getData(); // Instance de LigneProduction

                // Récupération de la valeur saisie dans [name*="[nom]"]
                $nomSaisi = $ligneForm->get('nom')->getData();
                $produit = $entityManager->getRepository(Produit::class)->findOneBy(['nom' => $nomSaisi]);

                if ($nomSaisi) {
                    $ligne->setProduit($produit); // Affectation à l'entité
                }

                // Association obligatoire de la ligne à la fiche principale
                $ligne->setFicheProduction($ficheProduction);
            }
            $ficheProduction->setUser($this->getUser());
            $entityManager->persist($ficheProduction);
            $entityManager->flush();

            $this->addFlash('success', 'La fiche de production a été enregistrée avec succès.');

            return $this->redirectToRoute('app_fiche_production_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('fiche_production/new.html.twig', [
            'fiche_production' => $ficheProduction,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/detaile', name: 'app_fiche_production_show', methods: ['GET'])]
    public function show(FicheProduction $ficheProduction): Response
    {
        return $this->render('fiche_production/show.html.twig', [
            'fiche_production' => $ficheProduction,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_fiche_production_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')] // 👈 Restriction par rôle
    public function edit(Request $request, FicheProduction $ficheProduction, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FicheProductionType::class, $ficheProduction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // 1. Gestion du champ 'produit' si non mappé dans FicheProductionType
            if ($form->has('produit')) {
                $produit = $form->get('produit')->getData();
                if ($produit) {
                    $ficheProduction->setProduit($produit);
                }
            }

            // 2. Traitement des lignes de production (composants)
            $lignesForms = $form->get('lignes');

            foreach ($lignesForms as $ligneForm) {
                /** @var LigneProduction $ligne */
                $ligne = $ligneForm->getData();

                // Récupération du champ 'nom' non mappé s'il est utilisé dans LigneProductionType
                if ($ligneForm->has('nom')) {
                    $nomSaisi = $ligneForm->get('nom')->getData();
                    $produit = $entityManager->getRepository(Produit::class)->findOneBy(['nom' => $nomSaisi]);

                    if ($produit) {
                        $ligne->setProduit($produit);
                    }
                }

                // Associer obligatoirement la ligne à la fiche principale
                $ligne->setFicheProduction($ficheProduction);

                // Persister les nouvelles lignes créées dynamiquement
                $entityManager->persist($ligne);
            }

            // 3. Sauvegarde en BDD
            $entityManager->flush();

            $this->addFlash('success', 'La fiche de production a été mise à jour avec succès.');

            return $this->redirectToRoute('app_fiche_production_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('fiche_production/edit.html.twig', [
            'fiche_production' => $ficheProduction,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_fiche_production_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')] // 👈 Restriction par rôle
    public function delete(Request $request, FicheProduction $ficheProduction, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ficheProduction->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($ficheProduction);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_fiche_production_index', [], Response::HTTP_SEE_OTHER);
    }
}
