<?php

namespace App\Controller;

use App\Entity\Badge;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/badge")
 */
class BadgeController extends AbstractCRUDController
{
    protected function getEntityClass(): string
    {
        return Badge::class;
    }
    /**
     * @Route("/", name="badge index", methods={"GET"})
     */
    public function index(Request $request): JsonResponse
    {
        return $this->getAll($request);
    }

    /**
     * overhiding the search querry
     */
    public function getSearchQuerry():string{
        return "u.name LIKE :search";
    }

    /**
     * @Route("/{elemCount}/{pageCount}", name="badge_page", methods={"GET"})
     */
    public function getAllWithPage(Request $request,int $elemCount,int $pageCount): JsonResponse
    {
        return $this->getAll($request,$pageCount,$elemCount);
    }
    /**
     * @Route("/{id}", name="badge show", methods={"GET"})
     */
    public function show(int $id): JsonResponse
    {
        return $this->getById($id);
    }
    /**
     * @Route("/{id}", name="badge remove", methods={"DELETE"})
     */
    public function remove(int $id): JsonResponse
    {
        return $this->delete($id,'ROLE_SUPERADMIN');
    }
    /**
     * @Route("/", name="badge new", methods={"POST"})
     */
    public function new(Request $request): JsonResponse
    {
        return $this->create($request, 'ROLE_SUPERADMIN');
    } 
    /**
     * @Route("/{id}", name="badge edit", methods={"PATCH"})
     */
    public function edit(int $id, Request $request): JsonResponse
    {
        return $this->update($id, $request, 'ROLE_SUPERADMIN');
    }

}
