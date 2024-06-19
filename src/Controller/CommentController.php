<?php

// src/Controller/CommentController.php

namespace App\Controller;

use App\Entity\Reviews;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    #[Route('/avis', name: 'comments_index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // Récupérer les commentaires
        $reviews = $entityManager->getRepository(Reviews::class)->findAll();

        // Rendre la vue avec les commentaires
        return $this->render('comment/_comments.html.twig', [
            'reviews' => $reviews,
        ]);
    }
}
