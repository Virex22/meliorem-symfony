<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Repository\ContactRepository;
use App\Service\ContactService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/contact")
 */
class ContactController extends AbstractController
{
    /**
     * @Route("/", name="contact_index", methods={"GET"})
     */
    public function index(ContactRepository $contactRepository): JsonResponse
    {
        return $this->json($contactRepository->findAll(), Response::HTTP_OK);
    }
    /**
     * @Route("/{id}", name="contact_show", methods={"GET"})
     */
    public function show(?Contact $contact): JsonResponse
    {
        if ($contact === null)
            return new JsonResponse(['error' => 'Contact not found'], Response::HTTP_NOT_FOUND);
        return $this->json($contact, Response::HTTP_OK);
    }

    /**
     * @Route("/{id}", name="contact_delete", methods={"DELETE"})
     */
    public function delete(?Contact $contact, EntityManagerInterface $entityManager): JsonResponse
    {
        if (!$this->isGranted('ROLE_SUPERADMIN'))
            return new JsonResponse(['error' => 'You are not authorized to delete a contact'], Response::HTTP_UNAUTHORIZED);
        if ($contact === null)
            return new JsonResponse(['error' => 'Contact not found'], Response::HTTP_NOT_FOUND);
            
        $entityManager->remove($contact);
        $entityManager->flush();

        return $this->json(['success' => 'Contact deleted'], Response::HTTP_OK);
    }
    /**
     * @Route("/", name="contact_create", methods={"POST"})
     */
    public function create(Request $request, ContactService $contactService): JsonResponse
    {
        if (!$this->isGranted('ROLE_SUPERADMIN'))
            return new JsonResponse(['error' => 'You are not authorized to create a contact'], Response::HTTP_UNAUTHORIZED);

        $data = json_decode($request->getContent(), true);
        try {
            $contact = $contactService->createContact($data);
        } catch (\Throwable $th) {
            return new JsonResponse(['error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        // return data with code created
        return $this->json($contact, Response::HTTP_CREATED);
    }
    /**
     * @Route("/{id}", name="contact_update", methods={"PATCH"})
     */
    public function update(?Contact $contact, Request $request, ContactService $contactService): JsonResponse
    {
        if (!$this->isGranted('ROLE_SUPERADMIN'))
            return new JsonResponse(['error' => 'You are not authorized to update a contact'], Response::HTTP_UNAUTHORIZED);
        if ($contact === null)
            return new JsonResponse(['error' => 'Contact not found'], Response::HTTP_NOT_FOUND);

        $data = json_decode($request->getContent(), true);
        try {
            $contact = $contactService->editContact($contact, $data);
        } catch (\Throwable $th) {
            return new JsonResponse(['error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
        return $this->json($contact, Response::HTTP_OK);
    }


}
