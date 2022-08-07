<?php

namespace App\Tests\Unit\Entity;

use App\Entity\ReadLater;
use PHPUnit\Framework\TestCase;

class ReadLaterTest extends TestCase
{

    
    public function testReadLaterConstructorGetterAndSetter(){
        $readLater = new ReadLater();
        $date = new \DateTime();
        $readLater->setAddDate($date)
        ->setPositionOrder(1);
        $this->assertNull($readLater->getId());
        $this->assertEquals($date, $readLater->getAddDate());
        $this->assertEquals(1, $readLater->getPositionOrder());

    }

}

