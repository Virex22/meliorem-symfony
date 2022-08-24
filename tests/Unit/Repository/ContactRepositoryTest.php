<?php

namespace App\Tests\Integration\Repository;

use App\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ContactRepositoryTest extends KernelTestCase {


    public function testContactRepository() {
        $kernel = self::bootKernel();
        $em = $kernel->getContainer()->get('doctrine')->getManager();
        $contactRepository = $em->getRepository(Contact::class);

        $contact =new Contact();
        $contact->setPhone("phonetest")
        ->setDescription("descriptiontest");

        $contactRepository->add($contact,true);
        $newContact = $contactRepository->findBy(['phone' => "phonetest"])[0];
        $contactRepository->remove($contact,true);
        $newContact = $contactRepository->findBy(['phone' => "phonetest"]);
        $this->assertEmpty($newContact);

    }

}