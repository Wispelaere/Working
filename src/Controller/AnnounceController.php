<?php

namespace App\Controller;

use App\Entity\Announces;
use App\Form\AnnounceType;
use App\Repository\AnnouncesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnounceController extends AbstractController
{
    #[Route('/announce', name: 'announce_index', methods: ['GET'])]
    public function index(AnnouncesRepository $announcesRepository): Response
    {
        return $this->render('announce/index.html.twig', [
            'announces' => $announcesRepository->findAll(),
        ]);
    }

    #[Route('/announce/new', name: 'announce_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $announce = new Announces();
        $form = $this->createForm(AnnounceType::class, $announce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($announce);
            $entityManager->flush();

            return $this->redirectToRoute('announce_index');
        }

        return $this->render('announce/new.html.twig', [
            'announce' => $announce,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/about', name: 'about', methods: ['GET'])]
    public function about(AnnouncesRepository $announcesRepository): Response
    {
        return $this->render('announce/about.html.twig', [
            'announces' => $announcesRepository->findAll(),
        ]);
    }
}
