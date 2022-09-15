<?php

namespace App\Controller;

use App\Entity\ReadLater;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/read-later")
 * */
class ReadLaterController extends AbstractCRUDController
{
    protected function getEntityClass(): string
    {
        return ReadLater::class;
    }
    /**
     * @Route("/", name="readLater index", methods={"GET"})
     */
    public function index(Request $request): JsonResponse
    {
        if ($request->query->has('search'))
            throw new \Exception("search not implemented on this entity");
        return $this->getAll($request);
    }
    /**
     * @Route("/{elemCount}/{pageCount}", name="readLater page", methods={"GET"})
     */
    public function getAllWithPage(Request $request,int $elemCount,int $pageCount): JsonResponse
    {
        if ($request->query->has('search'))
            throw new \Exception("search not implemented on this entity");
        return $this->getAll($request,$elemCount,$pageCount);
    }
    /**
     * @Route("/{id}", name="readLater show", methods={"GET"})
     */
    public function show(int $id): JsonResponse
    {
        return $this->getById($id);
    }
    /**
     * @Route("/{id}", name="readLater remove", methods={"DELETE"})
     */
    public function remove(int $id): JsonResponse
    {
        return $this->delete($id);
    }
    /**
     * @Route("/", name="readLater new", methods={"POST"})
     */
    public function new(Request $request): JsonResponse
    {
        return $this->create($request);
    }
    /**
     * @Route("/{id}", name="readLater edit", methods={"PATCH"})
     */
    public function edit(int $id, Request $request): JsonResponse
    {
        return $this->update($id, $request);
    }
}