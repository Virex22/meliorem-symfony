<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\ReceivedNotification;
use App\Repository\ReceivedNotificationRepository;
use App\Service\ReceivedNotificationService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @Route("/api/received-notification")
 */
class ReceivedNotificationController extends AbstractController
{
    /*
    * @Route("/", name="received_notification_index", methods={"GET"})
    */
    public function index(ReceivedNotificationRepository $receivedNotificationRepository): JsonResponse
    {
        return $this->json($receivedNotificationRepository->findAll(), Response::HTTP_OK);
    }

    /*
    * @Route("/{id}", name="received_notification_show", methods={"GET"})
    */
    public function show(?ReceivedNotification $receivedNotification): JsonResponse
    {
        if ($receivedNotification === null)
            return new JsonResponse(['error' => 'ReceivedNotification not found'], Response::HTTP_NOT_FOUND);
        return $this->json($receivedNotification, Response::HTTP_OK);
    }

    /*
    * @Route("/{id}", name="received_notification_delete", methods={"DELETE"})
    */
    public function delete(?ReceivedNotification $receivedNotification, EntityManagerInterface $entityManager): JsonResponse
    {
        if ($receivedNotification === null)
            return new JsonResponse(['error' => 'ReceivedNotification not found'], Response::HTTP_NOT_FOUND);

        $entityManager->remove($receivedNotification);
        $entityManager->flush();

        return $this->json(['success' => 'ReceivedNotification deleted'], Response::HTTP_OK);
    }

    /*
    * @Route("/", name="received_notification_create", methods={"POST"})
    */
    public function create(Request $request, ReceivedNotificationService $receivedNotificationService): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        
        try {
            $receivedNotification =  $receivedNotificationService->create($data);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
        return $this->json($receivedNotification, Response::HTTP_OK);
    }
    /*
    * @Route("/{id}", name="received_notification_update", methods={"PATCH"})
    */
    public function update(Request $request,?ReceivedNotification $receivedNotification , ReceivedNotificationService $receivedNotificationService): JsonResponse
    {
        if ($receivedNotification === null)
            return new JsonResponse(['error' => 'ReceivedNotification not found'], Response::HTTP_NOT_FOUND);
        $data = json_decode($request->getContent(), true);

        $receivedNotification = $receivedNotificationService->edit($receivedNotification, $data);
        return $this->json($receivedNotification, Response::HTTP_OK);
    }


}
