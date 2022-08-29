<?php

namespace App\Controller;

use App\Entity\TypeContact;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/type-contact")
 * */
class TypeContactController extends AbstractCRUDController
{
    protected function getEntityClass(): string
    {
        return TypeContact::class;
    }
    /**
     * @Route("/", name="typeContact index", methods={"GET"})
     */
    public function index(): JsonResponse
    {
        return $this->getAll();
    }
    /**
     * @Route("/{elemCount}/{pageCount}", name="typeContact page", methods={"GET"})
     */
    public function getAllWithPage(int $elemCount,int $pageCount): JsonResponse
    {
        return $this->getAll($elemCount,$pageCount);
    }
    /**
     * @Route("/{id}", name="typeContact show", methods={"GET"})
     */
    public function show(int $id): JsonResponse
    {
        return $this->getById($id);
    }
    /**
     * @Route("/{id}", name="typeContact remove", methods={"DELETE"})
     */
    public function remove(int $id): JsonResponse
    {
        try{
            return $this->delete($id);
        }
        catch(ForeignKeyConstraintViolationException $e){
            return $this->json(['message' => 'typeContact is in use and cannot be deleted', 'exceptionMessage' => $e->getMessage()], 400);
        }
    }
    /**
     * @Route("/", name="typeContact new", methods={"POST"})
     */
    public function new(Request $request): JsonResponse
    {
        return $this->create($request);
    }
    /**
     * @Route("/{id}", name="typeContact edit", methods={"PATCH"})
     */
    public function edit(int $id, Request $request): JsonResponse
    {
        return $this->update($id, $request);
    }
}