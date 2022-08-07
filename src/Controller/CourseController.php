<?php

namespace App\Controller;

use App\Entity\Course;
use App\Repository\CourseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/course")
 */
class CourseController extends AbstractController
{
   
    /**
     * @Route("/", name="course_list" , methods={"GET"})
     */
    public function index(CourseRepository $courseRepository): JsonResponse
    {
        return $this->json($courseRepository->findAll(), Response::HTTP_OK);
    }

    /**
     * @Route("/{id}", name="course_show", methods={"GET"})
     */
    public function show(?Course $course): JsonResponse
    {
        if ($course === null)
            return new JsonResponse(['error' => 'Course not found'], Response::HTTP_NOT_FOUND);
        return $this->json($course, Response::HTTP_OK);
    }

    /**
     * @Route("/{id}", name="course_delete", methods={"DELETE"})
     */
    public function delete(?Course $course, EntityManagerInterface $entityManager): JsonResponse
    {
        if (!$this->isGranted('ROLE_SUPERADMIN'))
            return new JsonResponse(['error' => 'You are not authorized to delete a course'], Response::HTTP_UNAUTHORIZED);
        if ($course === null)
            return new JsonResponse(['error' => 'Course not found'], Response::HTTP_NOT_FOUND);
            
        $entityManager->remove($course);
        $entityManager->flush();

        return $this->json(['success' => 'Course deleted'], Response::HTTP_OK);
    }

    /**
     * @Route("/", name="course_create", methods={"POST"})
     */
    public function create(Request $request, EntityManagerInterface $entityManager, CourseService $courseService): JsonResponse
    {
        if (!$this->isGranted('ROLE_SUPERADMIN'))
            return new JsonResponse(['error' => 'You are not authorized to create a course'], Response::HTTP_UNAUTHORIZED);
        $data = json_decode($request->getContent(), true);
        try {
            $course = $courseService->create($data);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
        return $this->json($course, Response::HTTP_CREATED);
    }

    /**
     * @Route("/{id}", name="course_update", methods={"PATCH"})
     */
    public function update(?Course $course, Request $request, CourseService $courseService): JsonResponse
    {
        if (!$this->isGranted('ROLE_SUPERADMIN'))
            return new JsonResponse(['error' => 'You are not authorized to update a course'], Response::HTTP_UNAUTHORIZED);
        $data = json_decode($request->getContent(), true);
        try {
            $course = $courseService->update($course, $data);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
        return $this->json($course, Response::HTTP_OK);
    }




}
