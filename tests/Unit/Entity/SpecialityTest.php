<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Speciality;
use PHPUnit\Framework\TestCase;

class SpecialityTest extends TestCase
{

    public function testSpecialityConstructorGetterAndSetter(){
        $date = new \DateTime();
        $speciality = new Speciality();
        $speciality->setName('speciality')
        ->setBeginAt($date);

        $this->assertNull($speciality->getId());
        $this->assertEquals('speciality', $speciality->getName());
        $this->assertEquals($date, $speciality->getBeginAt());
        
    }


}

