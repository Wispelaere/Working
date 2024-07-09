<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\RegistrationFormType;
use App\Security\UsersAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;



class RegistrationController extends AbstractController
{
    #[Route('/inscription', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, Security $security, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        $user = new Users();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            // Generate a token for email confirmation
            $user->setConfirmationToken(uniqid());

            $entityManager->persist($user);
            $entityManager->flush();

            // Send confirmation email
            $email = (new Email())
                ->from('noreply@example.com')
                ->to($user->getEmail())
                ->subject('Confirmation d\'inscription')
                ->html($this->renderView(
                    'emails/registration_confirmation.html.twig',
                    ['user' => $user]
                ));

            $mailer->send($email);

            return $this->redirectToRoute('app_home'); // Redirect to home or login page after registration
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
