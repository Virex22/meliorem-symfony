<?php

namespace App\Controller;

use App\Entity\QuizPart;
use App\Repository\QuizPartRepository;
use App\Service\QuizPartService;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuizPartController extends AbstractController
{
    
    /**
     * @Route("/api/quiz_part", name="get_quiz_part", methods={"GET"})
     */
    public function getAll(QuizPartRepository $quizPartRepository): JsonResponse
    {
        $quizParts = $quizPartRepository->findAll();
        return $this->json($quizParts,Response::HTTP_OK);
    }
    /**
     * @Route("/api/quiz_part/{id}", name="get_quiz_part_by_id", methods={"GET"})
     */
    public function getByID(?QuizPart $quizPart): JsonResponse
    {
        if ($quizPart === null)
            return new JsonResponse(['error' => 'QuizPart not found'], Response::HTTP_NOT_FOUND);
        return $this->json($quizPart,Response::HTTP_OK);
    }
    /**
     * @Route("/api/quiz_part", name="create_quiz_part", methods={"POST"})
     */
    public function create(Request $request, QuizPartService $quizPartService ): JsonResponse
    {
        if (!$this->isGranted('ROLE_SPEAKER'))
            return new JsonResponse(['error' => 'You are not authorized to create a user'], Response::HTTP_UNAUTHORIZED);

        $data = json_decode($request->getContent(), true);
        try {
            $quizPart = $quizPartService->createQuizPart($data);
        } catch (\Throwable $th) {
            return new JsonResponse(['error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
        
        // return data with code created
        return $this->json($quizPart, Response::HTTP_CREATED);
    }
    /**
     * @Route("/api/quiz_part/{id}", name="delete_quiz_part", methods={"DELETE"})
     */
    public function delete(QuizPart $quizPart, EntityManager $entityManager): JsonResponse
    {
        if (!$this->isGranted('ROLE_SPEAKER'))
            return new JsonResponse(['error' => 'You are not authorized to delete a user'], Response::HTTP_UNAUTHORIZED);
        $entityManager->remove($quizPart);
        $entityManager->flush();
        return new JsonResponse(['success' => 'QuizPart deleted'], Response::HTTP_OK);
    }

    /**
     * @Route("/api/quiz_part/{id}", name="update_quiz_part", methods={"PATCH"})
     */
    public function update(?QuizPart $quizPart, Request $request, QuizPartService $quizPartService): JsonResponse
    {   
        if (!$this->isGranted('ROLE_SPEAKER'))
            return new JsonResponse(['error' => 'You are not authorized to update a user'], Response::HTTP_UNAUTHORIZED);
        if ($quizPart === null)
            return new JsonResponse(['error' => 'QuizPart not found'], Response::HTTP_NOT_FOUND);
        $data = json_decode($request->getContent(), true);
        try {
            $quizPart = $quizPartService->updateQuizPart($quizPart, $data);
        } catch (\Throwable $th) {
            return new JsonResponse(['error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
        return $this->json($quizPart, Response::HTTP_OK);
    }

}
