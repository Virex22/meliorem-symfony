<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Contact;
use App\Entity\TypeContact;
use PHPUnit\Framework\TestCase;

class TypeContactTest extends TestCase
{

    
    public function testTypeContactConstructorGetterAndSetter(){
        $contact = new Contact();
        $typeContact = new TypeContact();
        $typeContact->setName('typeContact')
        ->addContact($contact);
        $this->assertContains($contact, $typeContact->getContacts());
        $typeContact->removeContact($contact);
        $this->assertNotContains($contact, $typeContact->getContacts());
        $this->assertNull($typeContact->getId());
        $this->assertEquals('typeContact', $typeContact->getName());
    }


}

