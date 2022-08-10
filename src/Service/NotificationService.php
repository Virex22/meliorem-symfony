<?php
namespace App\Service;

use App\Entity\Notification;

class NotificationService extends AbstractEntityService
{
    protected function getEntityClass() : string
    {
        return Notification::class;
    }

    public function create(Array $data) : Notification
    {
        $this->validateRequiredData($data, 'title', 'description','interaction');
        $notification = $this->createEntity($data, 'title', 'description','interaction');
    
        return $notification;
    }


    public function edit(object $notification ,Array $data) : Notification
    {
        $this->editEntity($notification, $data, 'title', 'description','interaction');
        
        
        return $notification;
    }
}