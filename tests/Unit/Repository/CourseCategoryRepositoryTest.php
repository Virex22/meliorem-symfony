<?php

namespace App\Tests\Unit\Repository;

use App\Entity\CourseCategory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CourseCategoryRepositoryTest extends KernelTestCase {


    public function testCourseCategoryRepository() {
        $kernel = self::bootKernel();
        $em = $kernel->getContainer()->get('doctrine')->getManager();
        $courseCategoryRepository = $em->getRepository(CourseCategory::class);
        
        $courseCategory = new CourseCategory();
        $courseCategory->setName('CourseCategory 1')
        ->setColor('#000000');

        $courseCategoryRepository->add($courseCategory,true);
        $newCourseCategory = $courseCategoryRepository->findBy(['name' => 'CourseCategory 1'])[0];
        $courseCategoryRepository->remove($courseCategory,true);
        $newCourseCategory = $courseCategoryRepository->findBy(['name' => 'CourseCategory 1']);
        $this->assertEmpty($newCourseCategory);


    }

}