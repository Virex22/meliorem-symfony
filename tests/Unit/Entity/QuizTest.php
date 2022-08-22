<?php

namespace App\Tests\Unit\Entity;

use App\Entity\CoursePartQuiz;
use App\Entity\Quiz;
use App\Entity\QuizPart;
use PHPUnit\Framework\TestCase;

class QuizTest extends TestCase
{

    
    public function testQuizConstructorGetterAndSetter(){
        $date = new \DateTime();
        $course = new CoursePartQuiz();
        $quiz = new Quiz();
        $quiz->setDescription("description")
        ->setTitle("je suis le numero 3738745")
        ->setPublic(true)
        ->setCreatedAt($date)
        ->setTimeToPerformAll(10)
        ->addCoursePartQuiz($course);
        $this->assertContains($course, $quiz->getCoursePartQuizzes());
        $quiz->removeCoursePartQuiz($course);
        $this->assertNotContains($course, $quiz->getCoursePartQuizzes());

        $this->assertEquals("description", $quiz->getDescription());
        $this->assertNull($quiz->getId());
        $this->assertEquals("description", $quiz->getDescription());
        $this->assertEquals(true, $quiz->isPublic());
        $this->assertEquals($date, $quiz->getCreatedAt());
        $this->assertEquals(10, $quiz->getTimeToPerformAll());
    }

    public function testQuizPartConstructorGetterAndSetter(){
        $quizPart = new QuizPart();
        $quizPart->setQuestion("question");
        $quizPart->setChoice("choice");
        $quizPart->setAnswer("answer");
        $quizPart->setTimeMaxToResponse(10);
        $quizPart->setQuizOrder(1);
        // not saved in bdd yet -> id is null
        $this->assertNull($quizPart->getId());
        $this->assertEquals("question", $quizPart->getQuestion());
        $this->assertEquals("choice", $quizPart->getChoice());
        $this->assertEquals("answer", $quizPart->getAnswer());
        $this->assertEquals(10, $quizPart->getTimeMaxToResponse());
        $this->assertEquals(1, $quizPart->getQuizOrder());
        $this->assertEquals($quizPart->getId(), $quizPart->getQuizId());
    }
    public function testLinkQuizPartToQuiz(){
        $quiz = new Quiz();
        $quizPart = new QuizPart();
        $quiz->addQuizPart($quizPart);
        $this->assertEquals($quiz, $quizPart->getQuiz());
        $this->assertContains($quizPart, $quiz->getQuizParts());
        $quiz->removeQuizPart($quizPart);
        $this->assertNull($quizPart->getQuiz());
        $this->assertNotContains($quizPart, $quiz->getQuizParts());
    }


}

