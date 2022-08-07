<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Badge;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class BadgeTest extends TestCase
{

    
    public function testBadgeConstructorGetterAndSetter(){
        $user = new User();
        $badge = new Badge();
        $badge->setName('badge')
        ->setDescription('description')
        ->setImage('image')
        ->addUser($user);

        $this->assertContains($user, $badge->getUser());
        $badge->removeUser($user);
        $this->assertNotContains($user, $badge->getUser());


        $this->assertNull($badge->getId());
        $this->assertEquals('badge', $badge->getName());
        $this->assertEquals('description', $badge->getDescription());
        $this->assertEquals('image', $badge->getImage());
    }

}

