<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Notification;
use App\Entity\ReceivedNotification;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class ReceivedNotificationTest extends TestCase
{

    
    public function testReceivedNotificationConstructorGetterAndSetter(){
        $notification = new Notification();
        $user = new User();
        $receivedNotification = new ReceivedNotification();
        $receivedNotification->setNotification($notification)
        ->setViewed(false)
        ->setUser($user);

        $this->assertNull($receivedNotification->getId());
        $this->assertSame($notification, $receivedNotification->getNotification());
        $this->assertFalse($receivedNotification->isViewed());
        $this->assertSame($user, $receivedNotification->getUser());
    
    }


}

