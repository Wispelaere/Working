<?php

namespace App\Controller;

use App\Repository\MealsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MealController extends AbstractController
{
    #[Route('/meal', name: 'app_meal')]
    public function index(MealsRepository $mealsRepository): Response
    {
        $meals = $mealsRepository->findAll();

        return $this->render('meal/index.html.twig', [
            'meals' => $meals,
            'controller_name' => 'MealController',
        ]);
    }
}
