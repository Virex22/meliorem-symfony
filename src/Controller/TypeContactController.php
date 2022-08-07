<?php

namespace App\Controller;

use App\Entity\TypeContact;
use App\Repository\TypeContactRepository;
use App\Service\TypeContactService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/type-contact")
 */
class TypeContactController extends AbstractController
{
    /**
     * @Route("/", name="type_contact_index", methods={"GET"})
     */
    public function index(TypeContactRepository $typeContactRepository): JsonResponse {
        return $this->json($typeContactRepository->findAll(), Response::HTTP_OK);
    }

    /**
     * @Route("/{id}", name="type_contact_show", methods={"GET"})
     */
    public function show(?TypeContact $typeContact): JsonResponse {
        if ($typeContact === null)
            return new JsonResponse(['error' => 'TypeContact not found'], Response::HTTP_NOT_FOUND);
        return $this->json($typeContact, Response::HTTP_OK);
    }

    /**
     * @Route("/{id}", name="type_contact_delete", methods={"DELETE"})
     */
    public function delete(?TypeContact $typeContact, EntityManagerInterface $entityManager): JsonResponse {
        if (!$this->isGranted('ROLE_ADMINISTRATION'))
            return new JsonResponse(['error' => 'You are not authorized to delete a type contact'], Response::HTTP_UNAUTHORIZED);
        if ($typeContact === null)
            return new JsonResponse(['error' => 'TypeContact not found'], Response::HTTP_NOT_FOUND);
        if ($typeContact->getContacts()->count() > 0)
            return new JsonResponse(['error' => 'TypeContact is used by contacts'], Response::HTTP_BAD_REQUEST);

        $entityManager->remove($typeContact);
        $entityManager->flush();

        return $this->json(['success' => 'TypeContact deleted'], Response::HTTP_OK);
    }

    /**
     * @Route("/", name="type_contact_create", methods={"POST"})
     */
    public function create(Request $request, TypeContactService $typeContactService) : JsonResponse {
        if (!$this->isGranted('ROLE_ADMINISTRATION'))
            return new JsonResponse(['error' => 'You are not authorized to create a type contact'], Response::HTTP_UNAUTHORIZED);

        $data = json_decode($request->getContent(), true);
        try {
            $typeContact = $typeContactService->create($data);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
        return $this->json($typeContact, Response::HTTP_CREATED);
    }

    /**
     * @Route("/{id}", name="type_contact_update", methods={"PATCH"})
     */
    public function update(Request $request, ?TypeContact $typeContact, TypeContactService $typeContactService) : JsonResponse {
        if (!$this->isGranted('ROLE_ADMINISTRATION'))
            return new JsonResponse(['error' => 'You are not authorized to update a type contact'], Response::HTTP_UNAUTHORIZED);
        if ($typeContact === null)
            return new JsonResponse(['error' => 'TypeContact not found'], Response::HTTP_NOT_FOUND);

        $data = json_decode($request->getContent(), true);
        try {
            $typeContact = $typeContactService->update($typeContact, $data);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
        return $this->json($typeContact, Response::HTTP_OK);

    }
    
}
