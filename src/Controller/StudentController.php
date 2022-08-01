<?php

namespace App\Controller;

use App\Entity\Student;
use App\Repository\StudentRepository;
use App\Service\StudentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/student")
 */
class StudentController extends AbstractController
{
    /**
     * @Route("/", name="student_index", methods={"GET"})
     */
    public function index(StudentRepository $studentRepository): JsonResponse
    {
        return $this->json($studentRepository->findAll(), Response::HTTP_OK);
    }

    /**
     * @Route("/{id}", name="student_show", methods={"GET"})
     */
    public function show(?Student $student): JsonResponse
    {
        if ($student === null)
            return new JsonResponse(['error' => 'Student not found'], Response::HTTP_NOT_FOUND);
        return $this->json($student, Response::HTTP_OK);
    }

    /**
     * @Route("/{id}", name="student_edit", methods={"PATCH"})
     */
    public function edit(Request $request, ?Student $student, StudentService $studentService): JsonResponse
    { 
        if (!$this->isGranted('ROLE_SUPERADMIN'))
            return new JsonResponse(['error' => 'You are not authorized to edit a user'], Response::HTTP_UNAUTHORIZED);
        if ($student === null)
            return new JsonResponse(['error' => 'Student not found'], Response::HTTP_NOT_FOUND);
        $data = json_decode($request->getContent(), true);
        try {
            $student = $studentService->edit($student, $data);
        }
        catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return $this->json($student, Response::HTTP_OK);
    }
}
