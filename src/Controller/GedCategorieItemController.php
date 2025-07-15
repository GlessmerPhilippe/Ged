<?php

namespace App\Controller;

use App\Entity\GedCategorieItem;
use App\Form\GedCategorieItemType;
use App\Repository\GedCategorieItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/ged/categorie-item')]
final class GedCategorieItemController extends AbstractController
{
    #[Route(name: 'app_ged_categorie_item_index', methods: ['GET'])]
    public function index(GedCategorieItemRepository $gedCategorieItemRepository): Response
    {
        return $this->render('ged_categorie_item/index.html.twig', [
            'ged_categorie_items' => $gedCategorieItemRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_ged_categorie_item_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $gedCategorieItem = new GedCategorieItem();
        $form = $this->createForm(GedCategorieItemType::class, $gedCategorieItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($gedCategorieItem);
            $entityManager->flush();

            return $this->redirectToRoute('app_ged_categorie_item_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ged_categorie_item/new.html.twig', [
            'ged_categorie_item' => $gedCategorieItem,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ged_categorie_item_show', methods: ['GET'])]
    public function show(GedCategorieItem $gedCategorieItem): Response
    {
        return $this->render('ged_categorie_item/show.html.twig', [
            'ged_categorie_item' => $gedCategorieItem,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_ged_categorie_item_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, GedCategorieItem $gedCategorieItem, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(GedCategorieItemType::class, $gedCategorieItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_ged_categorie_item_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ged_categorie_item/edit.html.twig', [
            'ged_categorie_item' => $gedCategorieItem,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ged_categorie_item_delete', methods: ['POST'])]
    public function delete(Request $request, GedCategorieItem $gedCategorieItem, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$gedCategorieItem->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($gedCategorieItem);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_ged_categorie_item_index', [], Response::HTTP_SEE_OTHER);
    }
}
