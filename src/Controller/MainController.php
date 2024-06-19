<?php
// src/Controller/MainController.php

namespace App\Controller;

use App\Entity\Reviews;
use App\Form\CommentFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class MainController extends AbstractController
{
    #[Route('/', name: 'main')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // Récupérer les commentaires
        $reviews = $entityManager->getRepository(Reviews::class)->findAll();

        return $this->render('main/index.html.twig', [
            'reviews' => $reviews,
        ]);
    }

    #[Route('/nouveau-avis', name: 'add_comment')]
    public function addComment(Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {
        $review = new Reviews();
        $form = $this->createForm(CommentFormType::class, $review);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $security->getUser(); // Assuming the user is logged in

            if ($user) {
                $review->setParent($user); // Set the current logged in user as parent
            }

            $entityManager->persist($review);
            $entityManager->flush();

            return $this->redirectToRoute('main');
        }

        return $this->render('main/add_comment.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
