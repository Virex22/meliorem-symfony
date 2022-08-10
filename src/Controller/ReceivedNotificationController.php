<?php

namespace App\Controller;

use App\Entity\ReceivedNotification;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/received-notification")
 * */
class ReceivedNotificationController extends AbstractCRUDController
{
    protected function getEntityClass(): string
    {
        return ReceivedNotification::class;
    }
    /**
     * @Route("/", name="receivedNotification index", methods={"GET"})
     */
    public function index(): JsonResponse
    {
        return $this->getAll();
    }
    /**
     * @Route("/{id}", name="receivedNotification show", methods={"GET"})
     */
    public function show(int $id): JsonResponse
    {
        return $this->getById($id);
    }
    /**
     * @Route("/{id}", name="receivedNotification remove", methods={"DELETE"})
     */
    public function remove(int $id): JsonResponse
    {
        return $this->delete($id);
    }
    /**
     * @Route("/", name="receivedNotification new", methods={"POST"})
     */
    public function new(Request $request): JsonResponse
    {
        return $this->create($request);
    }
    /**
     * @Route("/{id}", name="receivedNotification edit", methods={"PATCH"})
     */
    public function edit(int $id, Request $request): JsonResponse
    {
        return $this->update($id, $request);
    }
}