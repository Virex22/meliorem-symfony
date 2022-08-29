<?php

namespace App\Controller;

use App\Entity\CoursePartQuiz;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/course-part-quiz")
 * */
class CoursePartQuizController extends AbstractCRUDController
{
    protected function getEntityClass(): string
    {
        return CoursePartQuiz::class;
    }
    /**
     * @Route("/", name="coursePartQuiz index", methods={"GET"})
     */
    public function index(): JsonResponse
    {
        return $this->getAll();
    }
    /**
     * @Route("/{elemCount}/{pageCount}", name="coursePartQuiz page", methods={"GET"})
     */
    public function getAllWithPage(int $elemCount,int $pageCount): JsonResponse
    {
        return $this->getAll($elemCount,$pageCount);
    }
    /**
     * @Route("/{id}", name="coursePartQuiz show", methods={"GET"})
     */
    public function show(int $id): JsonResponse
    {
        return $this->getById($id);
    }
    /**
     * @Route("/{id}", name="coursePartQuiz remove", methods={"DELETE"})
     */
    public function remove(int $id): JsonResponse
    {
        return $this->delete($id);
    }
    /**
     * @Route("/", name="coursePartQuiz new", methods={"POST"})
     */
    public function new(Request $request): JsonResponse
    {
        return $this->create($request);
    }
    /**
     * @Route("/{id}", name="coursePartQuiz edit", methods={"PATCH"})
     */
    public function edit(int $id, Request $request): JsonResponse
    {
        return $this->update($id, $request);
    }
}