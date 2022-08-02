<?php

namespace App\Tests\Unit\Repository;

use App\Entity\ReceivedNotification;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ReceivedNotificationRepositoryTest extends KernelTestCase {


    public function testReceivedNotificationRepository() {
        $kernel = self::bootKernel();
        $em = $kernel->getContainer()->get('doctrine')->getManager();
        $receivedNotificationRepository = $em->getRepository(ReceivedNotification::class);
        $this->assertNotSame("TODO","implement more than constructor");

    }

}