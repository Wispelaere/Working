<?php
namespace App\Controller;

use App\Entity\Image;
use App\Form\ImageType;
use App\Repository\ImageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\DeleteImageType;

class ImageController extends AbstractController
{
    #[Route('/galerie', name: 'image_index')]
    public function index(ImageRepository $imageRepository): Response
    {
        return $this->render('image/index.html.twig', [
            'images' => $imageRepository->findAll(),
        ]);
    }

    #[Route('/galerie/nouveau', name: 'image_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $image = new Image();
        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('file')->getData();

            if ($file) {
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = uniqid() . '.' . $file->guessExtension();

                try {
                    $file->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Gérer l'exception
                }

                // Stocker le chemin relatif
                $image->setNamePhoto($originalFilename);
                $image->setPath('Image/' . $newFilename);

            }

            $entityManager->persist($image);
            $entityManager->flush();

            return $this->redirectToRoute('image_index');
        }

        return $this->render('image/new.html.twig', [
            'image' => $image,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/galerie/{id}/delete', name: 'image_delete', methods: ['POST'])]
    public function delete(Request $request, Image $image, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$image->getId(), $request->request->get('_token'))) {
            // Supprimer le fichier du système de fichiers
            $filePath = $this->getParameter('images_directory') . '/' . basename($image->getPath());
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // Supprimer l'entité Image de la base de données
            $entityManager->remove($image);
            $entityManager->flush();
        }

        return $this->redirectToRoute('image_index');
    }
}
