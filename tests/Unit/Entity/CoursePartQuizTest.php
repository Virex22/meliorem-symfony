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
        $coursePart = new CoursePart();

        $coursePartQuiz = new CoursePartQuiz();
        $coursePartQuiz->setQuiz($quiz)
        ->setCoursePart($coursePart);

        $this->assertNull($coursePartQuiz->getId());
        $this->assertEquals($quiz, $coursePartQuiz->getQuiz());
        $this->assertEquals($coursePart, $coursePartQuiz->getCoursePart());
    }

}

