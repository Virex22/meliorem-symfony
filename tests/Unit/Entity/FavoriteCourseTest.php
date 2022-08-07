<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Course;
use App\Entity\FavoriteCourse;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class FavoriteCourseTest extends TestCase
{

    
    public function testFavoriteCourseConstructorGetterAndSetter(){
        $course = new Course();
        $user = new User();
        $date = new \DateTime();
        $favoriteCourse = new FavoriteCourse();
        $favoriteCourse->setCourse($course)
        ->setUser($user)
        ->setAddDate($date);
        $this->assertNull($favoriteCourse->getId());
        $this->assertEquals($course, $favoriteCourse->getCourse());
        $this->assertEquals($user, $favoriteCourse->getUser());
        $this->assertEquals($date, $favoriteCourse->getAddDate());



    }

}

