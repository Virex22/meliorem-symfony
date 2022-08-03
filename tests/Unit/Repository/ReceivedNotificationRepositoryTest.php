<?php

namespace App\Tests\Unit\Repository;

use App\Entity\Notification;
use App\Entity\ReceivedNotification;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ReceivedNotificationRepositoryTest extends KernelTestCase {


    public function testReceivedNotificationRepository() {
        $kernel = self::bootKernel();
        $em = $kernel->getContainer()->get('doctrine')->getManager();
        $receivedNotificationRepository = $em->getRepository(ReceivedNotification::class);
        $NotificationRepository = $em->getRepository(Notification::class);

        $notification = new Notification();
        $notification->setTitle('Notification 2')
        ->setDescription('Notification 2')
        ->setInteraction('Notification 2');
        
        $NotificationRepository->add($notification,true);
        $newNotification = $NotificationRepository->findBy(['title' => 'Notification 2'])[0];

        $receivedNotification = new ReceivedNotification();
        $receivedNotification->setNotification($newNotification)
        ->setViewed(false);

        $receivedNotificationRepository->add($receivedNotification,true);
        $newReceivedNotification = $receivedNotificationRepository->findBy(['notification' => $newNotification])[0];
        $this->assertEquals($newNotification,$newReceivedNotification->getNotification());
        $receivedNotificationRepository->remove($receivedNotification,true);
        $newReceivedNotification = $receivedNotificationRepository->findBy(['notification' => $newNotification]);
        $this->assertEmpty($newReceivedNotification);
        


    }

}