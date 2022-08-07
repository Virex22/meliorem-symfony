<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Course;
use App\Entity\CourseCategory;
use PHPUnit\Framework\TestCase;

class CourseCategoryTest extends TestCase
{

    
    public function testCourseCategoryConstructorGetterAndSetter(){
        $course = new Course();

        $courseCategory = new CourseCategory();
        $courseCategory->setName('courseCategory')
        ->setColor('color')
        ->addCourse($course);
        $this->assertContains($course, $courseCategory->getCourses());
        $courseCategory->removeCourse($course);
        $this->assertNotContains($course, $courseCategory->getCourses());

        $this->assertNull($courseCategory->getId());
        $this->assertEquals('courseCategory', $courseCategory->getName());
        $this->assertEquals('color', $courseCategory->getColor());
    }

}

