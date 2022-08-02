<?php

namespace App\Tests\Unit\Repository;

use App\Entity\CoursePartQuiz;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CoursePartQuizRepositoryTest extends KernelTestCase {


    public function testCoursePartQuizRepository() {
        $kernel = self::bootKernel();
        $em = $kernel->getContainer()->get('doctrine')->getManager();
        $coursePartQuizRepository = $em->getRepository(CoursePartQuiz::class);
        $this->assertNotSame("TODO","implement more than constructor");

    }

}