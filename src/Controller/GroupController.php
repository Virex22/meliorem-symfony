<?php

namespace App\Controller;

use App\Entity\Group;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/group")
 * */
class GroupController extends AbstractCRUDController
{
    protected function getEntityClass(): string
    {
        return Group::class;
    }
    /**
     * overhiding the search querry
     */
    public function getSearchQuerry():string{
        return "u.name LIKE :search";
    }
    /**
     * @Route("/", name="group index", methods={"GET"})
     */
    public function index(Request $request): JsonResponse
    {
        return $this->getAll($request);
    }
    /**
     * @Route("/{elemCount}/{pageCount}", name="group page", methods={"GET"})
     */
    public function getAllWithPage(Request $request,int $elemCount,int $pageCount): JsonResponse
    {
        return $this->getAll($request,$elemCount,$pageCount);
    }
    /**
     * @Route("/{id}", name="group show", methods={"GET"})
     */
    public function show(int $id): JsonResponse
    {
        return $this->getById($id);
    }
    /**
     * @Route("/{id}", name="group remove", methods={"DELETE"})
     */
    public function remove(int $id): JsonResponse
    {
        return $this->delete($id);
    }
    /**
     * @Route("/", name="group new", methods={"POST"})
     */
    public function new(Request $request): JsonResponse
    {
        return $this->create($request);
    }
    /**
     * @Route("/{id}", name="group edit", methods={"PATCH"})
     */
    public function edit(int $id, Request $request): JsonResponse
    {
        return $this->update($id, $request);
    }
}