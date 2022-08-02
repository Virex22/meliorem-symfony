<?php

namespace App\Tests\Unit\Repository;

use App\Entity\CourseCategory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CourseCategoryRepositoryTest extends KernelTestCase {


    public function testCourseCategoryRepository() {
        $kernel = self::bootKernel();
        $em = $kernel->getContainer()->get('doctrine')->getManager();
        $courseCategoryRepository = $em->getRepository(CourseCategory::class);
        $this->assertNotSame("TODO","implement more than constructor");

    }

}