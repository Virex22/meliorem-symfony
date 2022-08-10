<?php

namespace App\Controller;

use App\Entity\Speaker;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/speaker")
 * */
class SpeakerController extends AbstractCRUDController
{
    protected function getEntityClass(): string
    {
        return Speaker::class;
    }
    /**
     * @Route("/", name="speaker index", methods={"GET"})
     */
    public function index(): JsonResponse
    {
        return $this->getAll();
    }
    /**
     * @Route("/{id}", name="speaker show", methods={"GET"})
     */
    public function show(int $id): JsonResponse
    {
        return $this->getById($id);
    }
}