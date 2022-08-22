<?php

namespace App\Tests\Unit\Repository;

use App\Entity\Quiz;
use App\Entity\QuizPart;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class QuizRepositoryTest extends KernelTestCase {


    public function testQuizRepository() {
        $kernel = self::bootKernel();
        $em = $kernel->getContainer()->get('doctrine')->getManager();
        $quizRepository = $em->getRepository(Quiz::class);

        $date = new \DateTime();
        $randomDesc = uniqid("description_");

        $quiz = new Quiz();
        $quiz->setDescription($randomDesc)
            ->setPublic(true)
            ->setCreatedAt($date)
            ->setTimeToPerformAll(10)
            ->setTitle("je suis le numero 453");

        $quizRepository->add($quiz,true);
        $newQuiz = $quizRepository->findBy(['description' => $randomDesc])[0];
        $this->assertEquals($randomDesc, $newQuiz->getDescription());
        $quizRepository->remove($quiz,true);
        $newQuiz = $quizRepository->findBy(['description' => $randomDesc]);
        $this->assertEmpty($newQuiz);
    }

    public function testQuizPartRepository(){
        $kernel = self::bootKernel();
        $em = $kernel->getContainer()->get('doctrine')->getManager();
        $quizPartRepository = $em->getRepository(QuizPart::class);

        $randomQuestion = uniqid("question_");
        $quizPart = new QuizPart();
        $quizPart->setQuestion($randomQuestion);
        $quizPart->setChoice("choice");
        $quizPart->setAnswer("answer");
        $quizPart->setTimeMaxToResponse(10);
        $quizPart->setQuizOrder(1);
        $quizPartRepository->add($quizPart,true);
        $newQuizPart = $quizPartRepository->findBy(['question' => $randomQuestion])[0];
        $this->assertEquals($randomQuestion, $newQuizPart->getQuestion());
        $quizPartRepository->remove($quizPart,true);
        $newQuizPart = $quizPartRepository->findBy(['question' => $randomQuestion]);
        $this->assertEmpty($newQuizPart);

    }


}