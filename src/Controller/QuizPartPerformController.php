<?php

namespace App\Controller;

use App\Entity\QuizPartPerform;
use App\Repository\QuizPartPerformRepository;
use App\Service\QuizPartPerformService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/quiz-part-perform")
 */
class QuizPartPerformController extends AbstractController
{
    /**
     * @Route("/", name="quizpartperform_index", methods={"GET"})
     */
    public function index(QuizPartPerformRepository $quizpartperformRepository): JsonResponse
    {
        return $this->json($quizpartperformRepository->findAll(), Response::HTTP_OK);
    }

    /**
     * @Route("/{id}", name="quizpartperform_show", methods={"GET"})
     */
    public function show(?QuizPartPerform $quizpartperform): JsonResponse
    {
        if ($quizpartperform === null)
            return new JsonResponse(['error' => 'QuizPartPerform not found'], Response::HTTP_NOT_FOUND);
        return $this->json($quizpartperform, Response::HTTP_OK);
    }

    /**
     * @Route("/{id}", name="quizpartperform_delete", methods={"DELETE"})
     */
    public function delete(?QuizPartPerform $quizpartperform, EntityManagerInterface $entityManager): JsonResponse
    {
        if (!$this->isGranted('ROLE_SUPERADMIN'))
            return new JsonResponse(['error' => 'You are not authorized to delete a QuizPartPerform'], Response::HTTP_UNAUTHORIZED);
        if ($quizpartperform === null)
            return new JsonResponse(['error' => 'QuizPartPerform not found'], Response::HTTP_NOT_FOUND);
            
        $entityManager->remove($quizpartperform);
        $entityManager->flush();

        return $this->json(['success' => 'QuizPartPerform deleted'], Response::HTTP_OK);
    }
    /**
     * @Route("/", name="quizpartperform_create", methods={"POST"})
     */
    public function create(Request $request, QuizPartPerformService $quizpartperformService): JsonResponse
    {
        if (!$this->isGranted('ROLE_SUPERADMIN'))
            return new JsonResponse(['error' => 'You are not authorized to create a QuizPartPerform'], Response::HTTP_UNAUTHORIZED);
        $data = json_decode($request->getContent(), true);
        try {
            $quizpartperform = $quizpartperformService->create($data);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
        if ($quizpartperform === null)
            return new JsonResponse(['error' => 'QuizPartPerform not created'], Response::HTTP_BAD_REQUEST);
        return $this->json($quizpartperform, Response::HTTP_CREATED);
    }

    /**
     * @Route("/{id}", name="quizpartperform_update", methods={"PATCH"})
     */
    public function update(?QuizPartPerform $quizpartperform, Request $request, QuizPartPerformService $quizpartperformService): JsonResponse
    {
        if (!$this->isGranted('ROLE_SUPERADMIN'))
            return new JsonResponse(['error' => 'You are not authorized to update a QuizPartPerform'], Response::HTTP_UNAUTHORIZED);
        if ($quizpartperform === null)
            return new JsonResponse(['error' => 'QuizPartPerform not found'], Response::HTTP_NOT_FOUND);
        $data = json_decode($request->getContent(), true);
        try {
            $quizpartperform = $quizpartperformService->update($quizpartperform, $data);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
        if ($quizpartperform === null)
            return new JsonResponse(['error' => 'QuizPartPerform not updated'], Response::HTTP_BAD_REQUEST);
        return $this->json($quizpartperform, Response::HTTP_OK);
    }


}
