<?php

namespace App\Controller;

use App\DTO\UserDTO;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/api/user")
 * */
class UserController extends AbstractController
{
    
    /**
     * @Route("/me", name="get_my_user", methods={"GET"})
     */
    public function getMyUser(Security $security): JsonResponse
    {
        $user = $security->getUser();
        $userDTO = new UserDTO();
        $userDTO->hydrate($user);
        return $this->json($userDTO->getData());
    }

    /**
     * @Route("/", name="user index", methods={"GET"})
     */
    public function index( Request $request,UserRepository $userRepository): JsonResponse
    {
        if ($request->query->get('search')){
            $users = $userRepository->createQueryBuilder('u')
                ->where('u.name LIKE :search')
                ->orWhere('u.email LIKE :search')
                ->setParameter('search', $request->query->get('search').'%')
                ->getQuery()
                ->getResult();
        }
        else
            $users = $userRepository->findAll();
        $usersDTO = [];
        foreach ($users as $user)
        {
            $userDTO = new UserDTO();
            $userDTO->hydrate($user);
            $usersDTO[] = $userDTO->getData();
        }
        return $this->json($usersDTO, Response::HTTP_OK);
    }
    /**
     * @Route("/{elemCount}/{pageCount}", name="badge page", methods={"GET"})
     */
    public function getAllWithPage(Request $request, ?int $elemCount,?int $pageCount,UserRepository $userRepository): JsonResponse
    { 
        $querry = $userRepository->createQueryBuilder('u')
        ->select('count(u.id)');
        if ($request->query->get('search')){
            $querry->where('u.name LIKE :search')
                ->orWhere('u.email LIKE :search')
                ->setParameter('search', $request->query->get('search').'%');
        }
        $totalCount = $querry->getQuery()
            ->getSingleScalarResult();
        $usersDTO = [];
        $users = $userRepository->findBy([], [], $elemCount, ($pageCount-1)*$elemCount);
        $maxPage = ceil($totalCount / $elemCount);
        foreach ($users as $user)
        {
            $userDTO = new UserDTO();
            $userDTO->hydrate($user);
            $usersDTO[] = $userDTO->getData();
        }
        return $this->json(["totalPage" => $maxPage ,"data" => $usersDTO], Response::HTTP_OK);
    }
    /**
     * @Route("/{id}", name="user show", methods={"GET"})
     */
    public function show(?User $user): JsonResponse
    {
        if (!$user)
            return $this->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        $userDTO = new UserDTO();
        $userDTO->hydrate($user);
        return $this->json($userDTO->getData(), Response::HTTP_OK);
    }
     /**
     * @Route("/{id}", name="delete user", methods={"DELETE"})
     */
    public function remove(?User $user,UserService $userService): JsonResponse
    {
        if (!$this->isGranted('ROLE_SUPERADMIN'))
            return new JsonResponse(['error' => 'You are not authorized to delete a user'], Response::HTTP_UNAUTHORIZED);
        if ($user === null)
            return new JsonResponse(['error' => 'User not found'], Response::HTTP_NOT_FOUND);

        $userService->deleteUser($user);

        return new JsonResponse(['success' => 'User deleted'], Response::HTTP_OK);
    }
    /**
     * @Route("/", name="create user", methods={"POST"})
     */
    public function create(Request $request,Security $security, UserService $userService): JsonResponse
    {
        if (!$security->isGranted('ROLE_SUPERADMIN'))
            return new JsonResponse(['error' => 'You are not authorized to create a user'], Response::HTTP_UNAUTHORIZED);

        $parameters = json_decode($request->getContent(), true);
        
        try {
            $user = $userService->createUser($parameters);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
        
        $userDTO = new UserDTO();
        $userDTO->hydrate($user);
        return $this->json($userDTO->getData(), Response::HTTP_CREATED);
    }
    /**
     * @Route("/{id}", name="edit_user", methods={"PATCH"})
     */
    public function edit(?User $user, Request $request, Security $security, UserService $userService): JsonResponse
    {
        if (!$security->isGranted('ROLE_SUPERADMIN'))
            return new JsonResponse(['error' => 'You are not authorized to edit a user'], Response::HTTP_UNAUTHORIZED);
        if ($user === null)
            return new JsonResponse(['error' => 'User not found'], Response::HTTP_NOT_FOUND);

        $parameters = json_decode($request->getContent(), true);

        try {
            $user = $userService->editUser($user, $parameters);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        $userDTO = new UserDTO();
        $userDTO->hydrate($user);
        return $this->json($userDTO->getData(), Response::HTTP_OK);
    }
}