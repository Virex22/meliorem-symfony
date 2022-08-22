<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Course;
use App\Entity\CourseCategory;
use App\Entity\CourseSection;
use App\Entity\FavoriteCourse;
use App\Entity\Group;
use App\Entity\ReadLater;
use App\Entity\Speaker;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class CourseTest extends TestCase
{

    
    public function testCourseConstructorGetterAndSetter(){
        $date = new \DateTime();
        $favoriteCourse = new FavoriteCourse();
        $readLater = new ReadLater();
        $groupFilter = new Group();
        $courseSection = new CourseSection();
        $category = new CourseCategory();
        $course = new Course();
        $user = new User();
        $user->setName("name");
        $user->setFirstname("firstname");
        $speaker = new Speaker();
        $speaker->setUser($user);
        $course->setTitle('course')
        ->setDescription('description')
        ->setImage('image')
        ->setIsPublic(true)
        ->setLastEditDate($date)
        ->setPublishDate($date)
        ->setSpeaker($speaker)
        ->addCourseCategory($category)
        ->addCourseSection($courseSection)
        ->addFavoriteCourse($favoriteCourse)
        ->addReadLater($readLater)
        ->addGroup($groupFilter);
        $this->assertContains($category, $course->getCourseCategory());
        $this->assertContains($courseSection, $course->getCourseSections());
        $this->assertContains($favoriteCourse, $course->getFavoriteCourses());
        $this->assertContains($readLater, $course->getReadLaters());
        $this->assertContains($groupFilter, $course->getGroup());

        $course->removeCourseCategory($category)
        ->removeCourseSection($courseSection)
        ->removeFavoriteCourse($favoriteCourse)
        ->removeReadLater($readLater)
        ->removeGroup($groupFilter);

        $this->assertNotContains($category, $course->getCourseCategory());
        $this->assertNotContains($courseSection, $course->getCourseSections());
        $this->assertNotContains($favoriteCourse, $course->getFavoriteCourses());
        $this->assertNotContains($readLater, $course->getReadLaters());
        $this->assertNotContains($groupFilter, $course->getGroup());

        $this->assertNull($course->getId());
        $this->assertEquals('course', $course->getTitle());
        $this->assertEquals('description', $course->getDescription());
        $this->assertEquals('image', $course->getImage());
        $this->assertEquals(true, $course->isIsPublic());
        $this->assertEquals($date, $course->getLastEditDate());
        $this->assertEquals($date, $course->getPublishDate());

        $this->assertNull($course->getSpeakerId());
        $this->assertNotNull($course->getSpeakerName());

        $course->getSpeaker()->setUser(null);

        $this->assertNull($course->getSpeakerName());
        $course->setSpeaker(null);
        $this->assertNull($course->getSpeakerId());


    }

}

