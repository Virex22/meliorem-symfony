<?php

namespace App\Tests\Unit\Entity;

use App\Entity\CoursePart;
use App\Entity\CoursePartQuiz;
use App\Entity\Quiz;
use PHPUnit\Framework\TestCase;

class CoursePartQuizTest extends TestCase
{

    
    public function testCoursePartQuizConstructorGetterAndSetter(){
        $quiz = new Quiz();
        $quiz->setDescription("uniq description for test");
        $coursePart = new CoursePart();
        $coursePart->setEstimatedTime(3543);

        $coursePartQuiz = new CoursePartQuiz();
        $coursePartQuiz->setQuiz($quiz)
        ->setCoursePart($coursePart);

        $this->assertNull($coursePartQuiz->getId());
        $this->assertEquals($quiz, $coursePartQuiz->getQuiz());
        $this->assertEquals($coursePart, $coursePartQuiz->getCoursePart());
        $this->assertContains("uniq description for test", $coursePartQuiz->getQuizInfo());
        $this->assertContains(3543, $coursePartQuiz->getCoursePartInfo());

        $coursePartQuiz->setQuiz(null);
        $coursePartQuiz->setCoursePart(null);

        $this->assertNull($coursePartQuiz->getQuizInfo());
        $this->assertNull($coursePartQuiz->getCoursePartInfo());
    }

}

