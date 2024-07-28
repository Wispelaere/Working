<?php

namespace App\Controller;

use App\Entity\Meetings;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MeetingController extends AbstractController
{
    #[Route('/api/meetings', name: 'create_meeting', methods: ['POST'])]
    public function createMeeting(Request $request, EntityManagerInterface $em): JsonResponse
    {
        // Vérifier si l'utilisateur est authentifié et a le rôle d'admin
        if (!$this->isGranted('ROLE_ADMIN')) {
            return new JsonResponse(['status' => 'Accès refusé'], 403);
        }

        $data = json_decode($request->getContent(), true);

        $meeting = new Meetings();
        $meeting->setNameMeeting($data['title']);
        $meeting->setDateMeeting(new \DateTime($data['start']));
        $meeting->setTimeMeeting(new \DateTime($data['start'])); // Dépend de ton format d'entrée

        $em->persist($meeting);
        $em->flush();

        return new JsonResponse(['status' => 'Meeting created!', 'id' => $meeting->getId()], 201);
    }

    #[Route('/api/meetings/{id}', name: 'delete_meeting', methods: ['DELETE'])]
    public function deleteMeeting($id, EntityManagerInterface $em): JsonResponse
    {
        // Vérifier si l'utilisateur est authentifié et a le rôle d'admin
        if (!$this->isGranted('ROLE_ADMIN')) {
            return new JsonResponse(['status' => 'Accès refusé'], 403);
        }

        $meeting = $em->getRepository(Meetings::class)->find($id);

        if (!$meeting) {
            return new JsonResponse(['status' => 'Meeting not found'], 404);
        }

        $em->remove($meeting);
        $em->flush();

        return new JsonResponse(['status' => 'Meeting deleted']);
    }

    #[Route('/api/meetings', name: 'get_meetings', methods: ['GET'])]
    public function getMeetings(EntityManagerInterface $em): JsonResponse
    {
        $meetings = $em->getRepository(Meetings::class)->findAll();

        $data = [];
        foreach ($meetings as $meeting) {
            $data[] = [
                'id' => $meeting->getId(),
                'title' => $meeting->getNameMeeting(),
                'start' => $meeting->getDateMeeting()->format('c'), // ISO 8601 format
                'end' => $meeting->getDateMeeting()->format('c'), // Ajuste selon ton besoin
                'backgroundColor' => $meeting->getParent() ? 'red' : '', // Couleur pour les créneaux bloqués
                'borderColor' => $meeting->getParent() ? 'red' : ''
            ];
        }

        return new JsonResponse($data);
    }
}
