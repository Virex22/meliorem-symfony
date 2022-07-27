<?php

namespace App\Controller;

use App\Entity\Quiz;
use App\Repository\QuizRepository;
use App\Service\QuizService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/api/quiz")
 */
class QuizController extends AbstractController
{
    /**
     * @Route("/", name="all_quiz", methods={"GET"})
     */
    public function getAll(QuizRepository $quizRepository): JsonResponse
    {
        $quizzes = $quizRepository->findAll();
        return $this->json($quizzes,Response::HTTP_OK);
    }

    /**
     * @Route("/{id}", name="get_quiz", methods={"GET"})
     */
    public function getByID(Quiz $quiz): JsonResponse
    {
        if ($quiz === null)
            return new JsonResponse(['error' => 'Quiz not found'], Response::HTTP_NOT_FOUND);
        return $this->json($quiz,Response::HTTP_OK);
    }

    /**
     * @Route("/", name="create_quiz", methods={"POST"})
     */
    public function create(Security $security, Request $request, QuizService $quizService ): JsonResponse
    {
        if (!$security->isGranted('ROLE_SPEAKER'))
            return new JsonResponse(['error' => 'You are not authorized to create a user'], Response::HTTP_UNAUTHORIZED);
        $data = json_decode($request->getContent(), true);
        try {
            $quiz = $quizService->createQuiz($data);
        } catch (\Throwable $th) {
            return new JsonResponse(['error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
        
        // return data with code created
        return $this->json($quiz, Response::HTTP_CREATED);
    }




}
