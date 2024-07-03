<?php
// src/Controller/AnnounceController.php

namespace App\Controller;

use App\Entity\Announces;
use App\Form\AnnounceType;
use App\Repository\AnnouncesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Security;

class AnnounceController extends AbstractController
{
    #[Route('/a-propos', name: 'about', methods: ['GET', 'POST'])]
    public function about(Request $request, AnnouncesRepository $announcesRepository, EntityManagerInterface $entityManager, Security $security): Response
    {
        // Récupération de toutes les annonces existantes
        $announces = $announcesRepository->findAll();

        // Initialisation du formulaire de création d'annonce
        $announce = new Announces();
        $form = $this->createForm(AnnounceType::class, $announce);
        $form->handleRequest($request);

        // Vérifie si l'utilisateur a le rôle admin pour soumettre le formulaire
        if ($form->isSubmitted() && $form->isValid() && $security->isGranted('ROLE_ADMIN')) {
            $entityManager->persist($announce);
            $entityManager->flush();

            return $this->redirectToRoute('about');
        }

        // Création des formulaires de suppression
        $deleteForms = [];
        foreach ($announces as $announce) {
            $deleteForms[$announce->getId()] = $this->createDeleteForm($announce)->createView();
        }

        return $this->render('announce/about.html.twig', [
            'announces' => $announces,
            'form' => $form->createView(),
            'delete_forms' => $deleteForms,
        ]);
    }

    #[Route('/admin/annonce/{id}/modifier', name: 'announce_modify', methods: ['GET', 'POST'])]
    public function modify(Request $request, Announces $announce, EntityManagerInterface $entityManager, Security $security): Response
    {
        // Vérifie les permissions pour l'accès admin
        if (!$security->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('Access Denied.');
        }

        $form = $this->createForm(AnnounceType::class, $announce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('about');
        }

        return $this->render('announce/modify.html.twig', [
            'announce' => $announce,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/annonce/{id}', name: 'announce_delete', methods: ['POST'])]
    public function delete(Request $request, Announces $announce, EntityManagerInterface $entityManager, Security $security): Response
    {
        // Vérifie les permissions pour l'accès admin
        if (!$security->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('Access Denied.');
        }

        // Vérifie le jeton CSRF
        if ($this->isCsrfTokenValid('delete' . $announce->getId(), $request->request->get('_token'))) {
            $entityManager->remove($announce);
            $entityManager->flush();
        }

        return $this->redirectToRoute('about');
    }

    private function createDeleteForm(Announces $announce)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('announce_delete', ['id' => $announce->getId()]))
            ->setMethod('DELETE')
            ->getForm();
    }
}
