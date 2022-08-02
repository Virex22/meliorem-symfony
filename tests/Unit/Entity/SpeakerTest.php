<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Course;
use App\Entity\Speaker;
use App\Entity\Speciality;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class SpeakerTest extends TestCase
{

    
    public function testSpeakerConstructorGetterAndSetter(){
        $user = new User();
        $speciality = new Speciality();
        $course = new Course();
        $speaker = new Speaker();
        $speaker->setUser($user)
        ->addSpeciality($speciality)
        ->addCourse($course);
        $this->assertContains($course, $speaker->getCourses());
        $this->assertContains($speciality, $speaker->getSpecialities());
        $speaker->removeCourse($course);
        $speaker->removeSpeciality($speciality);
        $this->assertNotContains($course, $speaker->getCourses());
        $this->assertNotContains($speciality, $speaker->getSpecialities());

        $this->assertNull($speaker->getId());
        $this->assertSame($user, $speaker->getUser());
    }


}

