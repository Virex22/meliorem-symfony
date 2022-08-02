<?php

namespace App\Tests\Unit\Repository;

use App\Entity\Speaker;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SpeakerRepositoryTest extends KernelTestCase {


    public function testSpeakerRepository() {
        $kernel = self::bootKernel();
        $em = $kernel->getContainer()->get('doctrine')->getManager();
        $speakerRepository = $em->getRepository(Speaker::class);
        $this->assertNotSame("TODO","implement more than constructor");

    }

}