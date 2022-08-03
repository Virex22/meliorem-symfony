<?php

namespace App\Tests\Unit\Repository;

use App\Entity\Course;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CourseRepositoryTest extends KernelTestCase {


    public function testCourseRepository() {
        $kernel = self::bootKernel();
        $em = $kernel->getContainer()->get('doctrine')->getManager();
        $courseRepository = $em->getRepository(Course::class);
        
        $course = new Course();
        $course->setTitle('Course 1')
            ->setDescription('Course 1 description')
            ->setImage('course1.png')
            ->setPublishDate(new \DateTime('01-01-2020'))
            ->setLastEditDate(new \DateTime('01-01-2020'))
            ->setIsPublic(true);

        $courseRepository->add($course,true);
        $newCourse = $courseRepository->findBy(['title' => 'Course 1'])[0];
        $courseRepository->remove($course,true);
        $newCourse = $courseRepository->findBy(['title' => 'Course 1']);
        $this->assertEmpty($newCourse);

    }

}