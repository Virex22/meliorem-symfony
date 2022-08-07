<?php

namespace App\Tests\Unit\Entity;

use App\Entity\QuizPart;
use App\Entity\QuizPartPerform;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class QuizPartPerformTest extends TestCase
{

    
    public function testQuizPartPerformConstructorGetterAndSetter(){
        $user = new User();
        $quizPart = new QuizPart();
        $date = new \DateTime();
        $quizPartPerform = new QuizPartPerform();

        $quizPartPerform->setUser($user)
        ->setQuizPart($quizPart)
        ->setDate($date)
        ->setScore(10)
        ->setTimeToResponse(120);
        $this->assertNull($quizPartPerform->getId());
        $this->assertEquals($user, $quizPartPerform->getUser());
        $this->assertEquals($quizPart, $quizPartPerform->getQuizPart());
        $this->assertEquals($date, $quizPartPerform->getDate());
        $this->assertEquals(10, $quizPartPerform->getScore());
        $this->assertEquals(120, $quizPartPerform->getTimeToResponse());
        


    }

}

