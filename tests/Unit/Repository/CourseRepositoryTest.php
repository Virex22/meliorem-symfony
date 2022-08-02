<?php

namespace App\Tests\Unit\Repository;

use App\Entity\Course;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CourseRepositoryTest extends KernelTestCase {


    public function testCourseRepository() {
        $kernel = self::bootKernel();
        $em = $kernel->getContainer()->get('doctrine')->getManager();
        $courseRepository = $em->getRepository(Course::class);
        $this->assertNotSame("TODO","implement more than constructor");

    }

}