<?php

namespace App\Tests\Unit\Repository;

use App\Entity\CourseSection;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CourseSectionRepositoryTest extends KernelTestCase {


    public function testCourseSectionRepository() {
        $kernel = self::bootKernel();
        $em = $kernel->getContainer()->get('doctrine')->getManager();
        $courseSectionRepository = $em->getRepository(CourseSection::class);
        $this->assertNotSame("TODO","implement more than constructor");

    }

}