<?php

namespace App\Tests\Unit\Repository;

use App\Entity\QuizPartPerform;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class QuizPartPerformRepositoryTest extends KernelTestCase {


    public function testQuizPartPerformRepository() {
        $kernel = self::bootKernel();
        $em = $kernel->getContainer()->get('doctrine')->getManager();
        $quizPartPerformRepository = $em->getRepository(QuizPartPerform::class);
        
        $quizPartPerform = new QuizPartPerform();
        $quizPartPerform->setDate(new \DateTime())
        ->setScore(13453543)
        ->setTimeToResponse(10);

        $quizPartPerformRepository->add($quizPartPerform,true);
        $newQuizPartPerform = $quizPartPerformRepository->findBy(['score' => 13453543])[0];
        $quizPartPerformRepository->remove($quizPartPerform,true);
        $newQuizPartPerform = $quizPartPerformRepository->findBy(['score' => 13453543]);
        $this->assertEmpty($newQuizPartPerform);

    }

}