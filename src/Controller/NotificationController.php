<?php

namespace App\Controller;

use App\Entity\Notification;
use App\Repository\NotificationRepository;
use App\Service\NotificationService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/notification")
 */
class NotificationController extends AbstractController
{
    /**
     * @Route("/", name="notification_index", methods={"GET"})
     */
    public function index(NotificationRepository $notificationRepository): JsonResponse
    {
        return $this->json($notificationRepository->findAll(), Response::HTTP_OK);
    }

    /**
     * @Route("/{id}", name="notification_show", methods={"GET"})
     */
    public function show(?Notification $notification): JsonResponse
    {
        if ($notification === null)
            return new JsonResponse(['error' => 'Notification not found'], Response::HTTP_NOT_FOUND);
        return $this->json($notification, Response::HTTP_OK);
    }

    /**
     * @Route("/{id}", name="notification_delete", methods={"DELETE"})
     */
    public function delete(?Notification $notification, EntityManagerInterface $entityManager): JsonResponse
    {
        if ($notification === null)
            return new JsonResponse(['error' => 'Notification not found'], Response::HTTP_NOT_FOUND);

        $entityManager->remove($notification);
        $entityManager->flush();

        return $this->json(['success' => 'Notification deleted'], Response::HTTP_OK);
    }

    /**
     * @Route("/", name="notification_create", methods={"POST"})
     */
    public function create(Request $request, NotificationService $notificationService): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        try {
            $notification = $notificationService->create($data);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
        
        return $this->json($notification, Response::HTTP_CREATED);
    }

    /**
     * @Route("/{id}", name="notification_update", methods={"PATCH"})
     */
    public function update(Request $request,?Notification $notification , NotificationService $notificationService): JsonResponse
    {
        if ($notification === null)
            return new JsonResponse(['error' => 'Notification not found'], Response::HTTP_NOT_FOUND);

        $data = json_decode($request->getContent(), true);
        try {
            $notification = $notificationService->update($notification, $data);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
        return $this->json($notification, Response::HTTP_OK);
    }



}


