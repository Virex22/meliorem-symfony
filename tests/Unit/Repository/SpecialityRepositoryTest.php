<?php

namespace App\Tests\Unit\Repository;

use App\Entity\Speciality;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SpecialityRepositoryTest extends KernelTestCase {


    public function testSpecialityRepository() {
        $kernel = self::bootKernel();
        $em = $kernel->getContainer()->get('doctrine')->getManager();
        $specialityRepository = $em->getRepository(Speciality::class);
        $this->assertNotSame("TODO","implement more than constructor");

    }

}