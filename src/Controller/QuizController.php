<?php

namespace App\Controller;

use App\Entity\Quiz;
use App\Repository\QuizRepository;
use App\Service\QuizService;
use Doctrine\ORM\EntityManager;
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
    public function getByID(?Quiz $quiz): JsonResponse
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

    /**
     * @Route("/{id}", name="delete_quiz", methods={"DELETE"})
     */
    public function delete(?Quiz $quiz, Security $security,EntityManager $entityManager): JsonResponse
    {
        if (!$security->isGranted('ROLE_SUPERADMIN'))
            return new JsonResponse(['error' => 'You are not authorized to delete a user'], Response::HTTP_UNAUTHORIZED);
        if ($quiz === null)
            return new JsonResponse(['error' => 'Quiz not found'], Response::HTTP_NOT_FOUND);
        
        $entityManager->remove($quiz);
        $entityManager->flush();
        return new JsonResponse(['success' => 'Quiz deleted'], Response::HTTP_OK);
    }

    /**
     * @Route("/{id}", name="update_quiz", methods={"PATCH"})
     */
    public function update(?Quiz $quiz, Request $request, Security $security, QuizService $quizService): JsonResponse
    {
        if (!$security->isGranted('ROLE_SUPERADMIN'))
            return new JsonResponse(['error' => 'You are not authorized to update a user'], Response::HTTP_UNAUTHORIZED);
        if ($quiz === null)
            return new JsonResponse(['error' => 'Quiz not found'], Response::HTTP_NOT_FOUND);
        $data = json_decode($request->getContent(), true);
        try {
            $quiz = $quizService->editQuiz($quiz, $data);
        } catch (\Throwable $th) {
            return new JsonResponse(['error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
        return $this->json($quiz, Response::HTTP_OK);
    }
    /**
     * @Route("/api/quiz/{id}/quiz-part", name="quiz_part", methods={"GET"})
     */
    public function getAllQuizParts(Quiz $quiz): JsonResponse
    {
        $quizParts = $quiz->getQuizParts();
        return $this->json($quizParts,Response::HTTP_OK);
    }


}
