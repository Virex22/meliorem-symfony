<?php

namespace App\Tests\Unit\Repository;

use App\Entity\ReadLater;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ReadLaterRepositoryTest extends KernelTestCase {


    public function testReadLaterRepository() {
        $kernel = self::bootKernel();
        $em = $kernel->getContainer()->get('doctrine')->getManager();
        $readLaterRepository = $em->getRepository(ReadLater::class);
        $this->assertNotSame("TODO","implement more than constructor");

    }

}