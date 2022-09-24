<?php

namespace App\Tests\Unit\Repository;

use App\Entity\CoursePartQuiz;
use App\Entity\Quiz;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CoursePartQuizRepositoryTest extends KernelTestCase
{


    public function testCoursePartQuizRepository()
    {
        $kernel = self::bootKernel();
        $em = $kernel->getContainer()->get('doctrine')->getManager();
        $coursePartQuizRepository = $em->getRepository(CoursePartQuiz::class);
        $quizRepository = $em->getRepository(Quiz::class);

        $quiz = new Quiz();
        $quiz->setDescription("random quiz test")
            ->setPublic(true)
            ->setTheme("theme")
            ->setCreatedAt(new \DateTime())
            ->setTimeToPerformAll(10)
            ->setTitle("titletestestest");
        $quizRepository->add($quiz, true);

        $coursePartQuiz = new CoursePartQuiz();
        $newQuiz = $quizRepository->findBy(['description' => "random quiz test"])[0];
        $coursePartQuiz->setQuiz($newQuiz);
        $coursePartQuizRepository->add($coursePartQuiz, true);
        $newCoursePartQuiz = $coursePartQuizRepository->findBy(['quiz' => $newQuiz])[0];
        $coursePartQuizRepository->remove($coursePartQuiz, true);
        $newCoursePartQuiz = $coursePartQuizRepository->findBy(['quiz' => $newQuiz]);
        $this->assertEmpty($newCoursePartQuiz);
        $quizRepository->remove($quiz, true);
    }
}
