<?php

namespace App\Tests\Unit\Repository;

use App\Entity\Notification;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class NotificationRepositoryTest extends KernelTestCase {


    public function testNotificationRepository() {
        $kernel = self::bootKernel();
        $em = $kernel->getContainer()->get('doctrine')->getManager();
        $notificationRepository = $em->getRepository(Notification::class);
        $this->assertNotSame("TODO","implement more than constructor");

    }

}