<?php
namespace App\Service;

use App\Entity\ReceivedNotification;

class ReceivedNotificationService extends AbstractEntityService
{
    protected function getEntityClass() : string
    {
        return ReceivedNotification::class;
    }

    public function create(Array $data) : ReceivedNotification
    {
        $this->validateRequiredData($data, 'notificationId', 'userId');
        if (!isset($data['viewed']))
            $data['viewed'] = false;
        $receivedNotification = $this->createEntity($data, 'notificationId', 'userId','viewed');
        
        return $receivedNotification;
    }


    public function edit(object $receivedNotification ,Array $data) : ReceivedNotification
    {
        $this->editEntity($receivedNotification, $data, 'notificationId', 'userId','viewed');
        
        return $receivedNotification;
    }
}