<?php

namespace App\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Users;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use Symfony\Component\Security\Core\Security;

class AdminController extends AbstractDashboardController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    #[Route('/mon-compte', name: 'app_mon_compte')]
    public function monCompte(Security $security): Response
    {
        // Récupérer l'utilisateur connecté
        $user = $security->getUser();

        // Vérifier si l'utilisateur est admin
        if ($this->isGranted('ROLE_ADMIN')) {
            // Si admin, rediriger vers le tableau de bord admin
            return $this->redirectToRoute('app_admin');
        }

        // Sinon, afficher la page normale de profil utilisateur
        return $this->render('mon_compte/index.html.twig', [
            'user' => $user,
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Les ptits plats de Kelly');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Users', 'fas fa-user', Users::class);
    }
}
