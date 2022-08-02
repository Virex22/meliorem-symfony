<?php

namespace App\Tests\Unit\Repository;

use App\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ContactRepositoryTest extends KernelTestCase {


    public function testContactRepository() {
        $kernel = self::bootKernel();
        $em = $kernel->getContainer()->get('doctrine')->getManager();
        $contactRepository = $em->getRepository(Contact::class);

        $contact =new Contact();
        $this->assertNotSame("TODO","implement more than constructor");

    }

}