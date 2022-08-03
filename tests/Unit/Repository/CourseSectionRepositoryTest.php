<?php

namespace App\Tests\Unit\Repository;

use App\Entity\CourseSection;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CourseSectionRepositoryTest extends KernelTestCase {


    public function testCourseSectionRepository() {
        $kernel = self::bootKernel();
        $em = $kernel->getContainer()->get('doctrine')->getManager();
        $courseSectionRepository = $em->getRepository(CourseSection::class);
        

        $courseSection = new CourseSection();
        $courseSection->setCourseOrder(1)
        ->setName('CourseSection 1');

        $courseSectionRepository->add($courseSection,true);
        $newCourseSection = $courseSectionRepository->findBy(['name' => 'CourseSection 1'])[0];
        $courseSectionRepository->remove($courseSection,true);
        $newCourseSection = $courseSectionRepository->findBy(['name' => 'CourseSection 1']);
        $this->assertEmpty($newCourseSection);

    }

}