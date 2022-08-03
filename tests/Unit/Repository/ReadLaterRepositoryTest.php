<?php

namespace App\Tests\Unit\Repository;

use App\Entity\ReadLater;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ReadLaterRepositoryTest extends KernelTestCase {


    public function testReadLaterRepository() {
        $kernel = self::bootKernel();
        $em = $kernel->getContainer()->get('doctrine')->getManager();
        $readLaterRepository = $em->getRepository(ReadLater::class);
        
        $readLater = new ReadLater();
        $readLater->setAddDate(new \DateTime())
        ->setPositionOrder(1234);

        $readLaterRepository->add($readLater,true);
        $newReadLater = $readLaterRepository->findBy(['positionOrder' => 1234])[0];
        $readLaterRepository->remove($readLater,true);
        $newReadLater = $readLaterRepository->findBy(['positionOrder' => 1234]);
        $this->assertEmpty($newReadLater);

    }

}