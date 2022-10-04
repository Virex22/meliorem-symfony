<?php

namespace App\Controller;

use App\Entity\Quiz;
use App\Repository\QuizRepository;
use App\Service\UnlinkTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/quiz")
 * */
class QuizController extends AbstractCRUDController
{
    protected function getEntityClass(): string
    {
        return Quiz::class;
    }
    /**
     * overhiding the search querry
     */
    public function getSearchQuerry(): string
    {
        return "u.title LIKE :search";
    }
    /**
     * @Route("/", name="quiz index", methods={"GET"})
     */
    public function index(Request $request): JsonResponse
    {
        return $this->getAll($request);
    }
    /**
     * @Route("/public/{elemCount}/{pageCount}", name="quiz public page", methods={"GET"})
     */
    public function getAllPublishWithPage(int $elemCount, int $pageCount, Request $request, QuizRepository $quizRepository): JsonResponse
    {
        $search = $request->query->get('search');

        $querry = $quizRepository->createQueryBuilder('u')
            ->select('count(u.id)');
        if ($search)
            $querry->where($this->getSearchQuerry())
                ->setParameter('search', $search . '%')
                ->andWhere('u.public = true');
        else
            $querry->where('u.public = true');
        $totalCount = $querry->getQuery()
            ->getSingleScalarResult();

        $querry = $quizRepository->createQueryBuilder('u');
        if ($search)
            $querry->where($this->getSearchQuerry())
                ->setParameter('search', $search . '%')
                ->andWhere('u.public = true');
        else
            $querry->where('u.public = true');
        $entities = $querry->setMaxResults($elemCount)
            ->setFirstResult($elemCount * ($pageCount - 1))
            ->getQuery()
            ->getResult();
        $maxPage = ceil($totalCount / $elemCount);

        return $this->json(["data" => $entities, "totalPage" => $maxPage], 200);
    }
    /**
     * @Route("/{elemCount}/{pageCount}", name="quiz page", methods={"GET"})
     */
    public function getAllWithPage(Request $request, int $elemCount, int $pageCount): JsonResponse
    {
        return $this->getAll($request, $elemCount, $pageCount);
    }
    /**
     * @Route("/{id}", name="quiz show", methods={"GET"})
     */
    public function show(int $id): JsonResponse
    {
        return $this->getById($id);
    }
    /**
     * @Route("/{id}", name="quiz remove", methods={"DELETE"})
     */
    public function remove(int $id): JsonResponse
    {
        return $this->delete($id);
    }
    /**
     * @Route("/", name="quiz new", methods={"POST"})
     */
    public function new(Request $request): JsonResponse
    {
        return $this->create($request);
    }
    /**
     * @Route("/{id}", name="quiz edit", methods={"PATCH"})
     */
    public function edit(int $id, Request $request): JsonResponse
    {
        return $this->update($id, $request);
    }
}
