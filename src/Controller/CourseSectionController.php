<?php

namespace App\Controller;

use App\Entity\CourseSection;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/course-section")
 * */
class CourseSectionController extends AbstractCRUDController
{
    protected function getEntityClass(): string
    {
        return CourseSection::class;
    }
    /**
     * overhiding the search querry
     */
    public function getSearchQuerry():string{
        return "u.name LIKE :search";
    }
    /**
     * @Route("/", name="courseSection index", methods={"GET"})
     */
    public function index(Request $request): JsonResponse
    {
        return $this->getAll($request);
    }
    /**
     * @Route("/{elemCount}/{pageCount}", name="courseSection page", methods={"GET"})
     */
    public function getAllWithPage(Request $request,int $elemCount,int $pageCount): JsonResponse
    {
        return $this->getAll($request,$elemCount,$pageCount);
    }
    /**
     * @Route("/{id}", name="courseSection show", methods={"GET"})
     */
    public function show(int $id): JsonResponse
    {
        return $this->getById($id);
    }
    /**
     * @Route("/{id}", name="courseSection remove", methods={"DELETE"})
     */
    public function remove(int $id): JsonResponse
    {
        return $this->delete($id);
    }
    /**
     * @Route("/", name="courseSection new", methods={"POST"})
     */
    public function new(Request $request): JsonResponse
    {
        return $this->create($request);
    }
    /**
     * @Route("/{id}", name="courseSection edit", methods={"PATCH"})
     */
    public function edit(int $id, Request $request): JsonResponse
    {
        return $this->update($id, $request);
    }
}