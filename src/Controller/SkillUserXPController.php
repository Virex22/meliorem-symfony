<?php

namespace App\Controller;

use App\Entity\SkillUserXP;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/skill-user-xp")
 * */
class SkillUserXPController extends AbstractCRUDController
{
    protected function getEntityClass(): string
    {
        return SkillUserXP::class;
    }
    /**
     * @Route("/", name="skillUserXP index", methods={"GET"})
     */
    public function index(): JsonResponse
    {
        return $this->getAll();
    }
    /**
     * @Route("/{elemCount}/{pageCount}", name="skillUserXp page", methods={"GET"})
     */
    public function getAllWithPage(int $elemCount,int $pageCount): JsonResponse
    {
        return $this->getAll($elemCount,$pageCount);
    }
    /**
     * @Route("/{id}", name="skillUserXP show", methods={"GET"})
     */
    public function show(int $id): JsonResponse
    {
        return $this->getById($id);
    }
    /**
     * @Route("/{id}", name="skillUserXP remove", methods={"DELETE"})
     */
    public function remove(int $id): JsonResponse
    {
        return $this->delete($id);
    }
    /**
     * @Route("/", name="skillUserXP new", methods={"POST"})
     */
    public function new(Request $request): JsonResponse
    {
        return $this->create($request);
    }
    /**
     * @Route("/{id}", name="skillUserXP edit", methods={"PATCH"})
     */
    public function edit(int $id, Request $request): JsonResponse
    {
        return $this->update($id, $request);
    }
}