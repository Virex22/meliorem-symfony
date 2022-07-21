<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Message;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
* @Route("/api/test")
*/
class TestController extends AbstractController
{
    /**
     * @Route("/ping", name="ping")
     */
    public function ping(): JsonResponse
    {
        return $this->json([
            "message" => "success"
        ]);
    }
    /**
     * @Route("/loginping", name="login_ping")
     */
    public function loginPing(Security $security): JsonResponse
    {
        $user = $security->getUser();
        if($user instanceof User)
            return $this->json([
                "message" => "success with login"
            ]);
        return $this->json([
            "message" => "error : user not found"
        ],500);
    }
}
