<?php

namespace App\Tests\Unit\Repository;

use App\Entity\TypeContact;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TypeContactRepositoryTest extends KernelTestCase {


    public function testTypeContactRepository() {
        $kernel = self::bootKernel();
        $em = $kernel->getContainer()->get('doctrine')->getManager();
        $typeContactRepository = $em->getRepository(TypeContact::class);
        $this->assertNotSame("TODO","implement more than constructor");

    }

}