<?php

namespace App\Tests\Unit\Repository;

use App\Entity\Notification;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class NotificationRepositoryTest extends KernelTestCase {


    public function testNotificationRepository() {
        $kernel = self::bootKernel();
        $em = $kernel->getContainer()->get('doctrine')->getManager();
        $notificationRepository = $em->getRepository(Notification::class);
        
        $notification = new Notification();
        $notification->setTitle('Notification 1')
        ->setDescription('Notification 1')
        ->setInteraction('Notification 1');

        $notificationRepository->add($notification,true);
        $newNotification = $notificationRepository->findBy(['title' => 'Notification 1'])[0];
        $notificationRepository->remove($notification,true);
        $newNotification = $notificationRepository->findBy(['title' => 'Notification 1']);
        $this->assertEmpty($newNotification);
        
    }

}