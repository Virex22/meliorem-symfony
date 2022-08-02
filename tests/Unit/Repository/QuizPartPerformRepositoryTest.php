<?php

namespace App\Tests\Unit\Repository;

use App\Entity\QuizPartPerform;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class QuizPartPerformRepositoryTest extends KernelTestCase {


    public function testQuizPartPerformRepository() {
        $kernel = self::bootKernel();
        $em = $kernel->getContainer()->get('doctrine')->getManager();
        $quizPartPerformRepository = $em->getRepository(QuizPartPerform::class);
        $this->assertNotSame("TODO","implement more than constructor");

    }

}