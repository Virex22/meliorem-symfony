<?php

namespace App\Controller;

use App\Entity\Skill;
use App\Repository\SkillRepository;
use App\Service\SkillService;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SkillController extends AbstractController
{
    /**
     * @Route("/api/skill", name="all_skill", methods={"GET"})
     */

    public function getAll(SkillRepository $skillRepository): JsonResponse
    {
        $skills = $skillRepository->findAll();
        return $this->json($skills, Response::HTTP_OK);
    }

    /**
     * @Route("/api/skill/{id}", name="get_skill", methods={"GET"})
     */
    public function getByID(?Skill $skill): JsonResponse
    {
        if ($skill === null)
            return new JsonResponse(['error' => 'Skill not found'], Response::HTTP_NOT_FOUND);
        return $this->json($skill, Response::HTTP_OK);
    }
    
    /**
     * @Route("/api/skill/{id}", name="delete_skill", methods={"DELETE"})
     */
    public function delete(?Skill $skill, EntityManager $entityManager): JsonResponse
    {
        if (!$this->isGranted('ROLE_SUPERADMIN'))
            return new JsonResponse(['error' => 'You are not authorized to delete a user'], Response::HTTP_UNAUTHORIZED);
        $entityManager->remove($skill);
        return $this->json(['success' => 'Skill deleted'], Response::HTTP_OK);
    }

    /**
     * @Route("/api/skill", name="create_skill", methods={"POST"})
     */
    public function create(Request $request, SkillRepository $skillRepository): JsonResponse
    {
        if (!$this->isGranted('ROLE_SUPERADMIN'))
            return new JsonResponse(['error' => 'You are not authorized to create a user'], Response::HTTP_UNAUTHORIZED);

        $data = json_decode($request->getContent(), true);
        try {
            $skill = $skillRepository->createSkill($data);
        } catch (\Throwable $th) {
            return new JsonResponse(['error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        // return data with code created
        return $this->json($skill, Response::HTTP_CREATED);
    }

    /**
     * @Route("/api/skill/{id}", name="update_skill", methods={"PATCH"})
     */
    public function update(Request $request, ?Skill $skill, SkillService $skillService): JsonResponse
    {
        if (!$this->isGranted('ROLE_SUPERADMIN'))
            return new JsonResponse(['error' => 'You are not authorized to update a user'], Response::HTTP_UNAUTHORIZED);
        if ($skill === null)
            return new JsonResponse(['error' => 'Skill not found'], Response::HTTP_NOT_FOUND);
        
        $parameters = json_decode($request->getContent(), true);
        try {
            $skill = $skillService->updateSkill($skill, $parameters);
        } catch (\Throwable $th) {
            return new JsonResponse(['error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }


        return $this->json($skill, Response::HTTP_OK);
    }

}
