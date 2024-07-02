<?php
namespace App\Controller;

//J'importe les classes utilisés
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
    // Route pour afficher la galerie d'images
    #[Route('/galerie', name: 'image_index')]
    public function index(ImageRepository $imageRepository): Response
    {
        // Rendu du template 'index.html.twig' avec les images récupérées du dépôt
        return $this->render('image/index.html.twig', [
            'images' => $imageRepository->findAll(),
        ]);
    }

    // Route pour ajouter une nouvelle image
    #[Route('/admin/galerie/nouveau', name: 'image_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $image = new Image(); // Création d'une nouvelle instance de l'entité Image
        $form = $this->createForm(ImageType::class, $image); // Création du formulaire pour l'image
        $form->handleRequest($request); // Gestion de la requête du formulaire

        // Vérification si le formulaire a été soumis et est valide
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('file')->getData(); // Récupération du fichier téléchargé

            if ($file) { // Si un fichier est téléchargé
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME); // Nom original du fichier
                $newFilename = uniqid() . '.' . $file->guessExtension(); // Nouveau nom unique pour le fichier

                try {
                    // Déplacement du fichier vers le répertoire des images
                    $file->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Gestion de l'exception en cas d'erreur lors du déplacement du fichier
                }

                // Stockage du chemin relatif de l'image
                $image->setNamePhoto($originalFilename);
                $image->setPath('Image/' . $newFilename);
            }

            // Persistance de l'entité Image dans la base de données
            $entityManager->persist($image);
            $entityManager->flush();

            // Redirection vers la galerie après l'ajout
            return $this->redirectToRoute('image_index');
        }

        // Rendu du template 'new.html.twig' avec le formulaire
        return $this->render('image/new.html.twig', [
            'image' => $image,
            'form' => $form->createView(),
        ]);
    }

    // Route pour supprimer une image (méthode POST)
    #[Route('/admin/galerie/{id}/delete', name: 'image_delete', methods: ['POST'])]
    public function delete(Request $request, Image $image, EntityManagerInterface $entityManager): Response
    {
        // Vérification du jeton CSRF pour sécuriser la suppression
        if ($this->isCsrfTokenValid('delete'.$image->getId(), $request->request->get('_token'))) {
            // Chemin du fichier à supprimer
            $filePath = $this->getParameter('images_directory') . '/' . basename($image->getPath());
            if (file_exists($filePath)) { // Vérification si le fichier existe
                unlink($filePath); // Suppression du fichier du système de fichiers
            }

            // Suppression de l'entité Image de la base de données
            $entityManager->remove($image);
            $entityManager->flush();
        }

        // Redirection vers la galerie après la suppression
        return $this->redirectToRoute('image_index');
    }
}