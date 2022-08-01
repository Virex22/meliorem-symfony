<?php
namespace App\Service;

use App\Entity\ReceivedNotification;
use Doctrine\ORM\EntityManagerInterface;

class ReceivedNotificationService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function create(Array $data){
        if (!isset($data['notificationId']))
            throw new \Exception('NotificationId is required');
        if (!isset($data['userId']))
            throw new \Exception('userId is required');
        $notification = $this->em->getRepository(Notification::class)->find($data['notificationId']);
        if (!$notification)
            throw new \Exception('NotificationId is invalid');
        $user = $this->em->getRepository(User::class)->find($data['userId']);
        if (!$user)
            throw new \Exception('userId is invalid');
        
        $receivedNotification = new ReceivedNotification();
        $receivedNotification->setNotification($notification)
            ->setUser($user)
            ->setViewed($data['viewed'] ?? false);

        $this->em->persist($receivedNotification);
        $this->em->flush();
        
        return $receivedNotification;
    }

    public function edit(ReceivedNotification $receivedNotification, Array $data){
        if (isset($data['viewed']))
            $receivedNotification->setViewed($data['viewed']);
        $this->em->persist($receivedNotification);
        $this->em->flush();
    }
}
?>