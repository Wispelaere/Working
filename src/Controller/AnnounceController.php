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
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Security;

class AnnounceController extends AbstractController
{
    #[Route('/annonce', name: 'about', methods: ['GET', 'POST'])]
    public function about(Request $request, AnnouncesRepository $announcesRepository, EntityManagerInterface $entityManager, Security $security): Response
    {
        $announces = $announcesRepository->findAll();

        // Handle new announce creation
        if ($request->isMethod('POST') && $security->isGranted('ROLE_ADMIN')) {
            $announce = new Announces();
            $form = $this->createForm(AnnounceType::class, $announce);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->persist($announce);
                $entityManager->flush();

                return $this->redirectToRoute('about');
            }

            return $this->render('announce/about.html.twig', [
                'announces' => $announces,
                'form' => $form->createView(),
            ]);
        }

        return $this->render('announce/about.html.twig', [
            'announces' => $announces,
            'form' => $this->createForm(AnnounceType::class)->createView(),
        ]);
    }

    #[Route('/admin/annonce/{id}/modifier', name: 'announce_modify', methods: ['GET', 'POST'])]
    public function modify(Request $request, Announces $announce, EntityManagerInterface $entityManager, Security $security): Response
    {
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
        if (!$security->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('Access Denied.');
        }

        if ($this->isCsrfTokenValid('delete' . $announce->getId(), $request->request->get('_token'))) {
            $entityManager->remove($announce);
            $entityManager->flush();
        }

        return $this->redirectToRoute('about');
    }

    #[Route('/admin/annonce/nouveau', name: 'announce_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {
        if (!$security->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('Access Denied.');
        }

        $announce = new Announces();
        $form = $this->createForm(AnnounceType::class, $announce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($announce);
            $entityManager->flush();

            return $this->redirectToRoute('about');
        }

        return $this->render('announce/new.html.twig', [
            'announce' => $announce,
            'form' => $form->createView(),
        ]);
    }
}
