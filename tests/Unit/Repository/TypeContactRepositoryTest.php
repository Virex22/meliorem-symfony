<?php

namespace App\Tests\Unit\Repository;

use App\Entity\TypeContact;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TypeContactRepositoryTest extends KernelTestCase {


    public function testTypeContactRepository() {
        $kernel = self::bootKernel();
        $em = $kernel->getContainer()->get('doctrine')->getManager();
        $typeContactRepository = $em->getRepository(TypeContact::class);
        
        $typeContact = new TypeContact();
        $typeContact->setName('TypeContact 1');

        $typeContactRepository->add($typeContact,true);
        $newTypeContact = $typeContactRepository->findBy(['name' => 'TypeContact 1'])[0];
        $this->assertEquals('TypeContact 1', $newTypeContact->getName());
        $typeContactRepository->remove($typeContact,true);
        $newTypeContact = $typeContactRepository->findBy(['name' => 'TypeContact 1']);
        $this->assertEmpty($newTypeContact);


    }

}