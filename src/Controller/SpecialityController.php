<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Speciality;
use App\Repository\SpecialityRepository;
use App\Service\SpecialityService;
use Doctrine\ORM\EntityManager;

/**
 * @Route("/api/speciality")
 */
class SpecialityController extends AbstractController
{
    /**
     * @Route("/", name="speciality_index", methods={"GET"})
     */
    public function index(SpecialityRepository $specialityRepository): JsonResponse
    {
        return $this->json($specialityRepository->findAll(), Response::HTTP_OK);
    }

    /**
     * @Route("/{id}", name="speciality_show", methods={"GET"})
     */
    public function show(?Speciality $speciality): JsonResponse
    {
        if ($speciality === null)
            return new JsonResponse(['error' => 'Speciality not found'], Response::HTTP_NOT_FOUND);
        return $this->json($speciality, Response::HTTP_OK);
    }

    /**
     * @Route("/{id}", name="speciality_delete", methods={"DELETE"})
     */
    public function delete(?Speciality $speciality, EntityManager $entityManager): JsonResponse
    {
        if ($speciality === null)
            return new JsonResponse(['error' => 'Speciality not found'], Response::HTTP_NOT_FOUND);

        $entityManager->remove($speciality);
        $entityManager->flush();

        return $this->json(['success' => 'Speciality deleted'], Response::HTTP_OK);
    }

    /**
     * @Route("/", name="speciality_create", methods={"POST"})
     */
    public function create(Request $request, SpecialityService $specialityService): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        
        try {
            $speciality =  $specialityService->create($data);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return $this->json($speciality, Response::HTTP_CREATED);
    }

    /**
     * @Route("/{id}", name="speciality_edit", methods={"PATCH"})
     */
    public function edit(Request $request, ?Speciality $speciality, SpecialityService $specialityService): JsonResponse
    {
        if ($speciality === null)
            return new JsonResponse(['error' => 'Speciality not found'], Response::HTTP_NOT_FOUND);
        $data = json_decode($request->getContent(), true);
        try {
            $speciality = $specialityService->edit($speciality, $data);
        }
        catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return $this->json($speciality, Response::HTTP_OK);
    }

    
    
}
