<?php

namespace App\Tests\Unit\Repository;

use App\Entity\CoursePart;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CoursePartRepositoryTest extends KernelTestCase {


    public function testCoursePartRepository() {
        $kernel = self::bootKernel();
        $em = $kernel->getContainer()->get('doctrine')->getManager();
        $coursePartRepository = $em->getRepository(CoursePart::class);
        $this->assertNotSame("TODO","implement more than constructor");

    }

}