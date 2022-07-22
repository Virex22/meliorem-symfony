<?php

namespace App\Controller;

use App\DTO\UserDTO;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/api/user")
*/
class UserController extends AbstractController
{
    /**
     * @Route("/", name="all_user")
     */
    public function getAll(UserRepository $userRepository): JsonResponse
    {
        $users = $userRepository->findAll();
        $usersDTO = [];
        foreach ($users as $user) {
            $userDTO = new UserDTO();
            $userDTO->hydrate($user);
            $usersDTO[] = $userDTO->getData();
        }
        return $this->json($usersDTO,200);
    }
    /**
     * @Route("/{id}", name="get_user")
     */
    public function getByID(User $user): JsonResponse
    {
        if ($user === null)
            return new JsonResponse(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
        $userDTO = new UserDTO();
        $userDTO->hydrate($user);
        return $this->json($userDTO->getData());
    }
}
