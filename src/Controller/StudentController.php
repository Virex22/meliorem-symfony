<?php

namespace App\Controller;

use App\Entity\Student;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/student")
 * */
class StudentController extends AbstractCRUDController
{
    protected function getEntityClass(): string
    {
        return Student::class;
    }
    /**
     * @Route("/", name="student index", methods={"GET"})
     */
    public function index(): JsonResponse
    {
        return $this->getAll();
    }
    /**
     * @Route("/{elemCount}/{pageCount}", name="student page", methods={"GET"})
     */
    public function getAllWithPage(int $elemCount,int $pageCount): JsonResponse
    {
        return $this->getAll($elemCount,$pageCount);
    }
    /**
     * @Route("/{id}", name="student show", methods={"GET"})
     */
    public function show(int $id): JsonResponse
    {
        return $this->getById($id);
    }
}