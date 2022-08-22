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
        $course->setDescription("uniq description for test");
        $user = new User();
        $user->setFirstname('uniq name for test');
        $date = new \DateTime();
        $favoriteCourse = new FavoriteCourse();
        $favoriteCourse->setCourse($course)
        ->setUser($user)
        ->setAddDate($date);
        $this->assertNull($favoriteCourse->getId());
        $this->assertEquals($course, $favoriteCourse->getCourse());
        $this->assertEquals($user, $favoriteCourse->getUser());
        $this->assertEquals($date, $favoriteCourse->getAddDate());

        $this->assertContains('uniq name for test', $favoriteCourse->getUserInfo());
        $this->assertContains('uniq description for test', $favoriteCourse->getCourseInfo());

        $favoriteCourse->setCourse(null);
        $favoriteCourse->setUser(null);

        $this->assertNull($favoriteCourse->getCourseInfo());
        $this->assertNull($favoriteCourse->getUserInfo());




    }

}

