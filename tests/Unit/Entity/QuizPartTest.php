<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Quiz;
use App\Entity\QuizPart;
use App\Entity\QuizPartPerform;
use App\Entity\Skill;
use PHPUnit\Framework\TestCase;

class QuizPartTest extends TestCase
{

    
    public function testQuizPartConstructorGetterAndSetter(){
        $quiz = new Quiz();
        $skill = new Skill();
        $quizPart = new QuizPart();
        $quizPartPerform = new QuizPartPerform();
        $quizPart->setQuestion('Question')
        ->setAnswer('Answer')
        ->setChoice('Choice')
        ->setTimeMaxToResponse(10)
        ->setQuizOrder(1)
        ->setQuiz($quiz)
        ->setSkill($skill)
        ->addQuizPartPerform($quizPartPerform);
        $this->assertContains($quizPartPerform, $quizPart->getQuizPartPerforms());
        $quizPart->removeQuizPartPerform($quizPartPerform);
        $this->assertNotContains($quizPartPerform, $quizPart->getQuizPartPerforms());

        $this->assertNull($quizPart->getId());
        $this->assertNull($quizPart->getQuizId());
        $this->assertEquals('Question', $quizPart->getQuestion());
        $this->assertEquals('Answer', $quizPart->getAnswer());
        $this->assertEquals('Choice', $quizPart->getChoice());
        $this->assertEquals(10, $quizPart->getTimeMaxToResponse());
        $this->assertEquals(1, $quizPart->getQuizOrder());
        $this->assertEquals($quiz, $quizPart->getQuiz());
        $this->assertEquals($skill, $quizPart->getSkill());
    }


}

