<?php

namespace App\Controller;

use App\Service\IService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Service\DeleteTrait;

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

abstract class AbstractCRUDController extends AbstractController
{
    private $entityManager;

    abstract protected function getEntityClass(): string;

    private function getEntityService(): object
    {
        $destructedClass = explode('\\', $this->getEntityClass());
        $serviceName = 'App\\Service\\'. end($destructedClass) . 'Service';
        return new $serviceName($this->entityManager);
    }

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getAll() : JsonResponse
    {
        $repository = $this->entityManager->getRepository($this->getEntityClass());
        return $this->json($repository->findAll());
    }

    public function getById(int $id) : JsonResponse
    {
        $repository = $this->entityManager->getRepository($this->getEntityClass());
        $entity = $repository->find($id);
        if (!$entity)
            return $this->json(['message' => 'element not found'], Response::HTTP_NOT_FOUND);
        return $this->json($entity);
    }
    
    public function delete(int $id,string $roleRestriction = null): JsonResponse
    {
        $entity = $this->entityManager->getRepository($this->getEntityClass())->find($id);
        if (!$entity)
            return $this->json(['message' => 'Element not found'], Response::HTTP_NOT_FOUND);
        if ($roleRestriction && !$this->isGranted($roleRestriction))
            return new JsonResponse(['error' => 'You are not authorized to delete this element'], Response::HTTP_UNAUTHORIZED);
        
        $entityService = $this->getEntityService();
        if (array_key_exists(DeleteTrait::class, class_uses($entityService))) 
            try {
                $entity = $this->getEntityService()->delete($entity,$this->entityManager);
            } catch (\Throwable $th) {
                return new JsonResponse(['error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
            }
        else {
            $this->entityManager->remove($entity);
            $this->entityManager->flush();
        }
        return $this->json(['success' => 'element deleted'], Response::HTTP_OK);
    }

    public function create(Request $request, string $roleRestriction =null): JsonResponse
    {
        $entityService = $this->getEntityService();
        if ($roleRestriction && !$this->isGranted($roleRestriction))
            return new JsonResponse(['error' => 'You are not authorized to create this element'], Response::HTTP_UNAUTHORIZED);

        $data = json_decode($request->getContent(), true);
        try {
            $entity = $entityService->create($data);
        } catch (\Throwable $th) {
            return new JsonResponse(['error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return $this->json($entity, Response::HTTP_CREATED);
    }
    
    public function update(int $id,Request $request, string $roleRestriction =null): JsonResponse
    {
        $entityService = $this->getEntityService();
        if ($roleRestriction && !$this->isGranted($roleRestriction))
            return new JsonResponse(['error' => 'You are not authorized to create this element'], Response::HTTP_UNAUTHORIZED);
        $entity = $this->entityManager->getRepository($this->getEntityClass())->find($id);
        if (!$entity)
            return new JsonResponse(['error' => 'Element not found'], Response::HTTP_NOT_FOUND);

        $data = json_decode($request->getContent(), true);
        try {
            $entity = $entityService->edit($entity, $data);
        } catch (\Throwable $th) {
            return new JsonResponse(['error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
        return $this->json($entity, Response::HTTP_OK);
    }


}
