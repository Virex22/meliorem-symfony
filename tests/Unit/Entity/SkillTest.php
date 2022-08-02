<?php

namespace App\Tests\Unit\Entity;

use App\Entity\QuizPart;
use App\Entity\Skill;
use App\Entity\SkillUserXP;
use PHPUnit\Framework\TestCase;

class SkillTest extends TestCase
{

    
    public function testSkillConstructorGetterAndSetter(){
        $skillUserXp = new SkillUserXP();
        $quizPart = new QuizPart();
        $skill = new Skill();
        $skill->setName('skill')
        ->setXpRequiredForLevels('[1,2,3,4,5,6,7,8,9,10]')
        ->setDescription('description')
        ->addSkillUserXP($skillUserXp)
        ->addQuizPart($quizPart);
        $this->assertContains($skillUserXp, $skill->getSkillUserXPs());
        $this->assertContains($quizPart, $skill->getQuizParts());
        $skill->removeSkillUserXP($skillUserXp);
        $skill->removeQuizPart($quizPart);
        $this->assertNotContains($skillUserXp, $skill->getSkillUserXPs());
        $this->assertNotContains($quizPart, $skill->getQuizParts());

        $this->assertNull($skill->getId());
        $this->assertEquals('skill', $skill->getName());
        $this->assertEquals('description', $skill->getDescription());
        $this->assertEquals('[1,2,3,4,5,6,7,8,9,10]', $skill->getXpRequiredForLevels());
    }


}

