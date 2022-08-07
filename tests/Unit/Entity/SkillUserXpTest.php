<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Skill;
use App\Entity\SkillUserXp;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class SkillUserXpTest extends TestCase
{

    
    public function testSkillUserXpConstructorGetterAndSetter(){
        $skill = new Skill();
        $user = new User();
        $skillUserXp = new SkillUserXp();
        $skillUserXp->setSkill($skill)
        ->setUser($user)
        ->setXp(15354);

        $this->assertNull($skillUserXp->getId());
        $this->assertEquals($skill, $skillUserXp->getSkill());
        $this->assertEquals($user, $skillUserXp->getUser());
        $this->assertEquals(15354, $skillUserXp->getXp());

    }

}

