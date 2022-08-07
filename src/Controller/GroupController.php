<?php

namespace App\Controller;

use App\Entity\Group;
use App\Repository\GroupRepository;
use App\Service\GroupService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/group")
 */
class GroupController extends AbstractController
{
    /**
     * @Route("/", name="group_index", methods={"GET"})
     */
    public function index(GroupRepository $groupRepository): JsonResponse
    {
        return $this->json($groupRepository->findAll(), Response::HTTP_OK);
    }

    /**
     * @Route("/{id}", name="group_show", methods={"GET"})
     */
    public function show(?Group $group): JsonResponse
    {
        if ($group === null)
            return new JsonResponse(['error' => 'Group not found'], Response::HTTP_NOT_FOUND);
        return $this->json($group, Response::HTTP_OK);
    }

    /**
     * @Route("/{id}", name="group_delete", methods={"DELETE"})
     */
    public function delete(?Group $group, EntityManagerInterface $entityManager): JsonResponse
    {
        if (!$this->isGranted('ROLE_SUPERADMIN'))
            return new JsonResponse(['error' => 'You are not authorized to delete a group'], Response::HTTP_UNAUTHORIZED);
        if ($group === null)
            return new JsonResponse(['error' => 'Group not found'], Response::HTTP_NOT_FOUND);
            
        $entityManager->remove($group);
        $entityManager->flush();

        return $this->json(['success' => 'Group deleted'], Response::HTTP_OK);
    }
    /**
     * @Route("/", name="group_create", methods={"POST"})
     */
    public function create(Request $request, GroupService $groupService): JsonResponse
    {
        if (!$this->isGranted('ROLE_SUPERADMIN'))
            return new JsonResponse(['error' => 'You are not authorized to create a group'], Response::HTTP_UNAUTHORIZED);
        $data = json_decode($request->getContent(), true);
        try {
            $group = $groupService->create($data);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
        if ($group === null)
            return new JsonResponse(['error' => 'Group not created'], Response::HTTP_BAD_REQUEST);
        return $this->json($group, Response::HTTP_CREATED);
    }

    /**
     * @Route("/{id}", name="group_update", methods={"PATCH"})
     */
    public function update(?Group $group, Request $request, GroupService $groupService): JsonResponse
    {
        if (!$this->isGranted('ROLE_SUPERADMIN'))
            return new JsonResponse(['error' => 'You are not authorized to update a group'], Response::HTTP_UNAUTHORIZED);
        if ($group === null)
            return new JsonResponse(['error' => 'Group not found'], Response::HTTP_NOT_FOUND);
        $data = json_decode($request->getContent(), true);
        try {
            $group = $groupService->update($group, $data);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
        if ($group === null)
            return new JsonResponse(['error' => 'Group not updated'], Response::HTTP_BAD_REQUEST);
        return $this->json($group, Response::HTTP_OK);
    }


}
