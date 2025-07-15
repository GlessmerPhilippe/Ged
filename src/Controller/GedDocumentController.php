<?php

namespace App\Controller;

use App\Entity\GedDocument;
use App\Service\GcsUploader;
use App\Form\GedDocumentType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\GedDocumentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Form\GedDocumentSearchType;

#[Route('/ged/document')]
final class GedDocumentController extends AbstractController
{
    #[Route(name: 'app_ged_document_index', methods: ['GET'])]
    public function index(Request $request, GedDocumentRepository $gedDocumentRepository): Response
    {
        $form = $this->createForm(GedDocumentSearchType::class);
        $form->handleRequest($request);

        $criteria = [];
        if ($form->isSubmitted() && $form->isValid()) {
            $criteria = $form->getData();
            // Convert tags string to array if present
            if (!empty($criteria['tags']) && is_string($criteria['tags'])) {
                $criteria['tags'] = array_map('trim', explode(',', $criteria['tags']));
            }

            $gedDocuments = $gedDocumentRepository->searchByCriteria($criteria);
        }else{
            $gedDocuments = $gedDocumentRepository->findAll();
        }


        return $this->render('ged_document/index.html.twig', [
            'ged_documents' => $gedDocuments,
            'search_form' => $form->createView(),
        ]);
    }

    #[Route('/new', name: 'app_ged_document_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,   GcsUploader $gcsUploader): Response
    {
        $gedDocument = new GedDocument();
        $form = $this->createForm(GedDocumentType::class, $gedDocument);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $file */
            $file = $form->get('gscFile')->getData();
            if ($file) {
                $gcsPath = $gcsUploader->upload($file);
                $gedDocument->setGscPath($gcsPath);
                $gedDocument->setMineType($file->getMimeType());
            }

            $gedDocument->setCreatedAt(new \DateTimeImmutable());
            $gedDocument->setUpdatedAt(new \DateTimeImmutable());
            $tagsInput = $form->get('tags')->getData();
            $tags = $tagsInput ? array_map('trim', explode(',', $tagsInput)) : [];
            $gedDocument->setTags($tags);
            $entityManager->persist($gedDocument);
            $entityManager->flush();
            $this->addFlash('success', 'Document ajouté avec succès.');

            return $this->redirectToRoute('app_ged_document_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ged_document/new.html.twig', [
            'ged_document' => $gedDocument,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ged_document_show', methods: ['GET'])]
    public function show(GedDocument $gedDocument, GcsUploader $gcsUploader): Response
    {
        $url = null;

        // Génère une URL signée si un fichier est associé
        if ($gedDocument->getGscPath()) {
            $url = $gcsUploader->generateSignedUrl($gedDocument->getGscPath(), '+30 minutes');
        }
        return $this->render('ged_document/show.html.twig', [
            'ged_document' => $gedDocument,
            'gcs_url' => $url,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_ged_document_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, GedDocument $gedDocument, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(GedDocumentType::class, $gedDocument);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_ged_document_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ged_document/edit.html.twig', [
            'ged_document' => $gedDocument,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ged_document_delete', methods: ['POST'])]
    public function delete(Request $request, GedDocument $gedDocument, EntityManagerInterface $entityManager,  GcsUploader $gcsUploader): Response
    {
        if ($this->isCsrfTokenValid('delete' . $gedDocument->getId(), $request->getPayload()->getString('_token'))) {
            // Supprimer le fichier dans GCS si présent
            if ($gedDocument->getGscPath()) {
                $gcsUploader->delete($gedDocument->getGscPath());
            }
            $entityManager->remove($gedDocument);
            $entityManager->flush();
            $this->addFlash('success', 'Document supprimé avec succès.');
        }

        return $this->redirectToRoute('app_ged_document_index', [], Response::HTTP_SEE_OTHER);
    }
}
