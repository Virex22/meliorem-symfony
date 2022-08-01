<?php

namespace App\Controller;

use App\Entity\Speaker;
use App\Repository\SpeakerRepository;
use App\Service\SpeakerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/speaker")
 */
class SpeakerController extends AbstractController
{

    /**
     * @Route("/", name="speaker_index", methods={"GET"})
     */
    public function index(SpeakerRepository $speakerRepository): JsonResponse
    {
        return $this->json($speakerRepository->findAll(), Response::HTTP_OK);
    }

    /**
     * @Route("/{id}", name="speaker_show", methods={"GET"})
     */
    public function show(?Speaker $speaker): JsonResponse
    {
        if ($speaker === null)
            return new JsonResponse(['error' => 'Speaker not found'], Response::HTTP_NOT_FOUND);
        return $this->json($speaker, Response::HTTP_OK);
    }

}
