<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Course;
use App\Entity\Group;
use App\Entity\Student;
use PHPUnit\Framework\TestCase;

class GroupTest extends TestCase
{

    
    public function testGroupConstructorGetterAndSetter(){
        $student = new Student();
        $course = new Course();

        $group = new Group();

        $group->setName('group')
        ->addCourse($course)
        ->addStudent($student);
        $this->assertContains($course, $group->getCourses());
        $this->assertContains($student, $group->getStudent());
        $group->removeCourse($course);
        $group->removeStudent($student);
        $this->assertNotContains($course, $group->getCourses());
        $this->assertNotContains($student, $group->getStudent());

        $this->assertNull($group->getId());
        $this->assertEquals('group', $group->getName());


    }

}

