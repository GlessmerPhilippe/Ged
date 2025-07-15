<?php

namespace App\Controller;

use App\Entity\GedCategorie;
use App\Form\GedCategorieType;
use App\Repository\GedCategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/ged/categorie')]
final class GedCategorieController extends AbstractController
{
    #[Route(name: 'app_ged_categorie_index', methods: ['GET'])]
    public function index(GedCategorieRepository $gedCategorieRepository): Response
    {
        return $this->render('ged_categorie/index.html.twig', [
            'ged_categories' => $gedCategorieRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_ged_categorie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $gedCategorie = new GedCategorie();
        $form = $this->createForm(GedCategorieType::class, $gedCategorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($gedCategorie);
            $entityManager->flush();

            return $this->redirectToRoute('app_ged_categorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ged_categorie/new.html.twig', [
            'ged_categorie' => $gedCategorie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ged_categorie_show', methods: ['GET'])]
    public function show(GedCategorie $gedCategorie): Response
    {
        return $this->render('ged_categorie/show.html.twig', [
            'ged_categorie' => $gedCategorie,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_ged_categorie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, GedCategorie $gedCategorie, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(GedCategorieType::class, $gedCategorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_ged_categorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ged_categorie/edit.html.twig', [
            'ged_categorie' => $gedCategorie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ged_categorie_delete', methods: ['POST'])]
    public function delete(Request $request, GedCategorie $gedCategorie, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$gedCategorie->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($gedCategorie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_ged_categorie_index', [], Response::HTTP_SEE_OTHER);
    }
}
