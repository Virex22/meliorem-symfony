<?php

namespace App\Controller;

use App\Entity\CoursePart;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/course-part")
 * */
class CoursePartController extends AbstractCRUDController
{
    protected function getEntityClass(): string
    {
        return CoursePart::class;
    }
    /**
     * @Route("/", name="coursePart index", methods={"GET"})
     */
    public function index(): JsonResponse
    {
        return $this->getAll();
    }
    /**
     * @Route("/{elemCount}/{pageCount}", name="coursePart page", methods={"GET"})
     */
    public function getAllWithPage(int $elemCount,int $pageCount): JsonResponse
    {
        return $this->getAll($elemCount,$pageCount);
    }
    /**
     * @Route("/{id}", name="coursePart show", methods={"GET"})
     */
    public function show(int $id): JsonResponse
    {
        return $this->getById($id);
    }
    /**
     * @Route("/{id}", name="coursePart remove", methods={"DELETE"})
     */
    public function remove(int $id): JsonResponse
    {
        return $this->delete($id);
    }
    /**
     * @Route("/", name="coursePart new", methods={"POST"})
     */
    public function new(Request $request): JsonResponse
    {
        return $this->create($request);
    }
    /**
     * @Route("/{id}", name="coursePart edit", methods={"PATCH"})
     */
    public function edit(int $id, Request $request): JsonResponse
    {
        return $this->update($id, $request);
    }
}