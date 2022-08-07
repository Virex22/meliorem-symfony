<?php

namespace App\Tests\Unit\Entity;

use App\Entity\CoursePart;
use App\Entity\CoursePartDocument;
use App\Entity\CoursePartQuiz;
use App\Entity\CourseSection;
use PHPUnit\Framework\TestCase;

class CoursePartTest extends TestCase
{

    
    public function testCoursePartConstructorGetterAndSetter(){
        $course = new CourseSection();
        $coursePartDocument = new CoursePartDocument();
        $coursePartQuiz = new CoursePartQuiz();
        $date = new \DateTime();

        $coursePart = new CoursePart();
        $coursePart->setTitle('coursePart')
        ->setOrderPart(1)
        ->setEstimatedTime(500)
        ->setCourseSection($course)
        ->setCoursePartDocument($coursePartDocument)
        ->setCoursePartQuiz($coursePartQuiz);

        $this->assertNull($coursePart->getId());
        $this->assertEquals('coursePart', $coursePart->getTitle());
        $this->assertEquals(1, $coursePart->getOrderPart());
        $this->assertEquals(500, $coursePart->getEstimatedTime());
        $this->assertEquals($course, $coursePart->getCourseSection());
        $this->assertEquals($coursePartDocument, $coursePart->getCoursePartDocument());
        $this->assertEquals($coursePartQuiz, $coursePart->getCoursePartQuiz());

        $coursePart->setCoursePartDocument(null);
        $coursePart->setCoursePartQuiz(null);
        $this->assertNull($coursePart->getCoursePartDocument());
        $this->assertNull($coursePart->getCoursePartQuiz());
    }

}

