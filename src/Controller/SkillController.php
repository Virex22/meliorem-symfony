<?php

namespace App\Controller;

use App\Entity\Skill;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/skill")
 * */
class SkillController extends AbstractCRUDController
{
    public function getSearchQuerry():string{
        return "u.description LIKE :name";
    }
    protected function getEntityClass(): string
    {
        return Skill::class;
    }
    /**
     * @Route("/", name="skill index", methods={"GET"})
     */
    public function index(Request $request): JsonResponse
    {
        return $this->getAll($request);
    }
    /**
     * @Route("/{id}", name="skill show", methods={"GET"})
     */
    public function show(int $id): JsonResponse
    {
        return $this->getById($id);
    }
    /**
     * @Route("/{elemCount}/{pageCount}", name="skill page", methods={"GET"})
     */
    public function getAllWithPage(Request $request,int $elemCount,int $pageCount): JsonResponse
    {
        return $this->getAll($request,$elemCount,$pageCount);
    }
    /**
     * @Route("/{id}", name="skill remove", methods={"DELETE"})
     */
    public function remove(int $id): JsonResponse
    {
        try{
            return $this->delete($id);
        }
        catch(ForeignKeyConstraintViolationException $e){
            return $this->json(['message' => 'Skill is in use and cannot be deleted', 'exceptionMessage' => $e->getMessage()], 400);
        }
    }
    /**
     * @Route("/", name="skill new", methods={"POST"})
     */
    public function new(Request $request): JsonResponse
    {
        return $this->create($request);
    }
    
    /**
     * @Route("/{id}", name="skill edit", methods={"PATCH"})
     */
    public function edit(int $id, Request $request): JsonResponse
    {
        return $this->update($id, $request);
    }
}