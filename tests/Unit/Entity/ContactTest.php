<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Contact;
use App\Entity\TypeContact;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class ContactTest extends TestCase
{

    
    public function testContactConstructorGetterAndSetter(){
        $typeContact = new TypeContact();
        $user = new User();
        $quiz = new Contact();
        $quiz->setDescription("description")
        ->setPhone("phone")
        ->setTypeContact($typeContact)
        ->setUser($user);

        $this->assertNull($quiz->getId());
        $this->assertEquals("description", $quiz->getDescription());
        $this->assertEquals("phone", $quiz->getPhone());
        $this->assertEquals($typeContact, $quiz->getTypeContact());
        $this->assertEquals($user, $quiz->getUser());
        $this->assertEquals($quiz->getTypeContact()->getName(), $quiz->getTypeContactName());
        $this->assertEquals($quiz->getUser()->getId(), $quiz->getUserId());
    }

}

