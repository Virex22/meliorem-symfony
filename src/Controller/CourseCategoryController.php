<?php

namespace App\Controller;

use App\Entity\CourseCategory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/course-category")
 * */
class CourseCategoryController extends AbstractCRUDController
{
    protected function getEntityClass(): string
    {
        return CourseCategory::class;
    }
    /**
     * @Route("/", name="courseCategory index", methods={"GET"})
     */
    public function index(): JsonResponse
    {
        return $this->getAll();
    }
    /**
     * @Route("/{id}", name="courseCategory show", methods={"GET"})
     */
    public function show(int $id): JsonResponse
    {
        return $this->getById($id);
    }
    /**
     * @Route("/{id}", name="courseCategory remove", methods={"DELETE"})
     */
    public function remove(int $id): JsonResponse
    {
        return $this->delete($id);
    }
    /**
     * @Route("/", name="courseCategory new", methods={"POST"})
     */
    public function new(Request $request): JsonResponse
    {
        return $this->create($request);
    }
    /**
     * @Route("/{id}", name="courseCategory edit", methods={"PATCH"})
     */
    public function edit(int $id, Request $request): JsonResponse
    {
        return $this->update($id, $request);
    }
}