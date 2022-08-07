<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Course;
use App\Entity\CoursePart;
use App\Entity\CourseSection;
use PHPUnit\Framework\TestCase;

class CourseSectionTest extends TestCase
{

    
    public function testCourseSectionConstructorGetterAndSetter(){
        $coursePart = new CoursePart();
        $course = new Course();
        $courseSection = new CourseSection();

        $courseSection->setName('courseSection')
        ->setCourseOrder(1)
        ->addCoursePart($coursePart)
        ->setCourse($course);

        $this->assertContains($coursePart, $courseSection->getCourseParts());
        $courseSection->removeCoursePart($coursePart);
        $this->assertNotContains($coursePart, $courseSection->getCourseParts());

        $this->assertNull($courseSection->getId());
        $this->assertEquals('courseSection', $courseSection->getName());
        $this->assertEquals(1, $courseSection->getCourseOrder());
        $this->assertEquals($course, $courseSection->getCourse());
    }

}

