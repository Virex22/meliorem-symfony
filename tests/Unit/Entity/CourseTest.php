<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Course;
use App\Entity\CourseCategory;
use App\Entity\CourseSection;
use App\Entity\FavoriteCourse;
use App\Entity\Group;
use App\Entity\ReadLater;
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
        $course->setTitle('course')
        ->setDescription('description')
        ->setImage('image')
        ->setIsPublic(true)
        ->setLastEditDate($date)
        ->setPublishDate($date)
        ->addCategory($category)
        ->addCourseSection($courseSection)
        ->addFavoriteCourse($favoriteCourse)
        ->addReadLater($readLater)
        ->addGroupFilter($groupFilter);
        $this->assertContains($category, $course->getCategory());
        $this->assertContains($courseSection, $course->getCourseSections());
        $this->assertContains($favoriteCourse, $course->getFavoriteCourses());
        $this->assertContains($readLater, $course->getReadLaters());
        $this->assertContains($groupFilter, $course->getGroupFilter());

        $course->removeCategory($category)
        ->removeCourseSection($courseSection)
        ->removeFavoriteCourse($favoriteCourse)
        ->removeReadLater($readLater)
        ->removeGroupFilter($groupFilter);

        $this->assertNotContains($category, $course->getCategory());
        $this->assertNotContains($courseSection, $course->getCourseSections());
        $this->assertNotContains($favoriteCourse, $course->getFavoriteCourses());
        $this->assertNotContains($readLater, $course->getReadLaters());
        $this->assertNotContains($groupFilter, $course->getGroupFilter());

        $this->assertNull($course->getId());
        $this->assertEquals('course', $course->getTitle());
        $this->assertEquals('description', $course->getDescription());
        $this->assertEquals('image', $course->getImage());
        $this->assertEquals(true, $course->isIsPublic());
        $this->assertEquals($date, $course->getLastEditDate());
        $this->assertEquals($date, $course->getPublishDate());
    }

}

