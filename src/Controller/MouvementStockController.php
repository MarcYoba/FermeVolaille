<?php

namespace App\Controller;

use App\Entity\MouvementStock;
use App\Form\MouvementStockType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MouvementStockController extends AbstractController
{
    #[Route('/gestionnaire/mouvement/stock/new', name: 'app_mouvement_stock')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $mouvement = new MouvementStock();
        $form = $this->createForm(MouvementStockType::class, $mouvement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $aliment = $mouvement->getAliment();
            $quantite = $mouvement->getQuantite();

            // METTRE À JOUR LE STOCK RÉEL EN FONCTION DU TYPE DE MOUVEMENT
            switch ($mouvement->getTypeMouvement()) {
                case MouvementStock::TYPE_ENTREE:
                    $aliment->setQuantiteStock($aliment->getQuantiteStock() + $quantite);
                    // Optionnel : Mettre à jour le prix d'achat si renseigné
                    if ($mouvement->getPrixUnitaireAchat()) {
                        $aliment->setPrixUnitaire($mouvement->getPrixUnitaireAchat());
                    }
                    break;

                case MouvementStock::TYPE_SORTIE:
                case MouvementStock::TYPE_TRANSFERT:
                    $aliment->setQuantiteStock($aliment->getQuantiteStock() - $quantite);
                    break;

                case MouvementStock::TYPE_INVENTAIRE:
                    // En cas d'inventaire, la quantité saisie devient la nouvelle quantité exacte
                    $aliment->setQuantiteStock($quantite);
                    break;
            }
            $mouvement->setUser($this->getUser());
            $em->persist($mouvement);
            $em->persist($aliment);
            $em->flush();

            // Vérifier s'il faut afficher une alerte de stock
            if ($aliment->isAlerteStock()) {
                $this->addFlash('warning', sprintf('Attention ! Le stock de "%s" est désormais critique (%s restantes).', $aliment->getNom(), $aliment->getQuantiteStock()));
            } else {
                $this->addFlash('success', 'Mouvement de stock enregistré avec succès !');
            }

            return $this->redirectToRoute('app_mouvement_stock_list');
        }

        return $this->render('mouvement_stock/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/gestionnaire/mouvement/stock/list', name: 'app_mouvement_stock_list')]
    public function list(EntityManagerInterface $em): Response
    {
        $mouvements = $em->getRepository(MouvementStock::class)->findAll();
        return $this->render('mouvement_stock/list.html.twig', [
            'mouvements' => $mouvements,
        ]);
    }

    #[Route('/admin/mouvement/stock/{id}/edit', name: 'app_mouvement_stock_edit')]
    public function edit(EntityManagerInterface $em, int $id, Request $request): Response
    {
        $mouvement = $em->getRepository(MouvementStock::class)->find($id);
        if (!$mouvement) {
            throw $this->createNotFoundException('Mouvement non trouvé');
        }

        $form = $this->createForm(MouvementStockType::class, $mouvement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('app_mouvement_stock_list');
        }

        return $this->render('mouvement_stock/edit.html.twig', [
            'form' => $form->createView(),
            'mouvement' => $mouvement,
        ]);
    
    }

    #[Route('/admin/mouvement/stock/{id}/delete', name: 'app_mouvement_stock_delete')]
    public function delete(EntityManagerInterface $em, int $id): Response
    {
        $mouvement = $em->getRepository(MouvementStock::class)->find($id);
        if (!$mouvement) {
            return $this->redirectToRoute('app_mouvement_stock_list');
        }

        $em->remove($mouvement);
        $em->flush();

        return $this->redirectToRoute('app_mouvement_stock_list');

    }
}