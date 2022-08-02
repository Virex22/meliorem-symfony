<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Notification;
use App\Entity\ReceivedNotification;
use PHPUnit\Framework\TestCase;

class NotificationTest extends TestCase
{

    
    public function testNotificationConstructorGetterAndSetter(){
        $receivedNotification = new ReceivedNotification();
        $notification = new Notification();
        $notification->setTitle('title')
        ->setDescription('description')
        ->setInteraction('interaction')
        ->addReceivedNotification($receivedNotification);
        $this->assertEquals($receivedNotification, $notification->getReceivedNotifications()[0]);
        $notification->removeReceivedNotification($receivedNotification);
        $this->assertEmpty($notification->getReceivedNotifications());

        $this->assertNull($notification->getId());
        $this->assertEquals('title', $notification->getTitle());
        $this->assertEquals('description', $notification->getDescription());
        $this->assertEquals('interaction', $notification->getInteraction());
    }


}

