<?php
namespace App\Controller;

use App\Repository\MenusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MenuController extends AbstractController
{
    private $menusRepository;

    public function __construct(MenusRepository $menusRepository)
    {
        $this->menusRepository = $menusRepository;
    }

    #[Route('/menu', name: 'app_menu')]
    public function index(): Response
    {
        $menus = $this->menusRepository->findAll();

        return $this->render('menu/index.html.twig', [
            'menus' => $menus,
            'controller_name' => 'MenuController',
        ]);
    }
}
