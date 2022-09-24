<?php

namespace App\Controller;

use App\Entity\Speaker;
use App\Entity\User;
use App\Repository\SpeakerRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/api/speaker")
 * */
class SpeakerController extends AbstractCRUDController
{
    protected function getEntityClass(): string
    {
        return Speaker::class;
    }

    /**
     * @Route("/me/quiz", name="speaker_get_quiz", methods={"GET"})
     */
    public function getQuiz(SpeakerRepository $speakerRepository, Security $security): JsonResponse
    {
        $user = $security->getUser();
        if (!$user instanceof User)
            throw new \Exception("user is not connected");
        $speaker = $user->getSpeaker();
        if (!$speaker)
            throw new \Exception("user is not a speaker");
        return $this->json($speaker->getQuizzes());
    }

    /**
     * @Route("/", name="speaker index", methods={"GET"})
     */
    public function index(Request $request): JsonResponse
    {
        if ($request->query->has('search'))
            throw new \Exception("search not implemented on this entity");
        return $this->getAll($request);
    }
    /**
     * @Route("/{elemCount}/{pageCount}", name="speakerController page", methods={"GET"})
     */
    public function getAllWithPage(Request $request, int $elemCount, int $pageCount): JsonResponse
    {
        if ($request->query->has('search'))
            throw new \Exception("search not implemented on this entity");
        return $this->getAll($request, $elemCount, $pageCount);
    }
    /**
     * @Route("/{id}", name="speaker show", methods={"GET"})
     */
    public function show(int $id): JsonResponse
    {
        return $this->getById($id);
    }
}
