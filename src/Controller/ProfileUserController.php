<?php

namespace App\Controller;

use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/profil')]
class ProfileUserController extends AbstractController
{
    #[Route('/', name: 'app_profile')]
    public function index(UsersRepository $usersRepository): Response
    {
        return $this->render('profile_user/index.html.twig', [
            'utilisateurs' => $usersRepository->findAll(),
        ]);
    }
}
