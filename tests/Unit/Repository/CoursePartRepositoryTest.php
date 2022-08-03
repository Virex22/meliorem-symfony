<?php

namespace App\Tests\Unit\Repository;

use App\Entity\CoursePart;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CoursePartRepositoryTest extends KernelTestCase {


    public function testCoursePartRepository() {
        $kernel = self::bootKernel();
        $em = $kernel->getContainer()->get('doctrine')->getManager();
        $coursePartRepository = $em->getRepository(CoursePart::class);
        
        $coursePart = new CoursePart();
        $coursePart->setTitle('CoursePart 1')
            ->setEstimatedTime(new \DateTime('01-01-2020'))
            ->setOrderPart(1);

        $coursePartRepository->add($coursePart,true);
        $newCoursePart = $coursePartRepository->findBy(['title' => 'CoursePart 1'])[0];
        $coursePartRepository->remove($coursePart,true);
        $newCoursePart = $coursePartRepository->findBy(['title' => 'CoursePart 1']);
        $this->assertEmpty($newCoursePart);

    }

}