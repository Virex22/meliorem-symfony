<?php
namespace App\Service;

use App\Entity\Notification;
use Doctrine\ORM\EntityManagerInterface;

class NotificationService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function create(Array $notification){
        if (!isset($notification['title']))
            throw new \Exception('Title is required');
        if (!isset($notification['message']))
            throw new \Exception('Message is required');
        
        $notification = new Notification();
        $notification->setTitle($notification['title'])
            ->setDescription($notification['message']);

        if (isset($notification['interaction']))
            $notification->setInteraction($notification['interaction']);

        $this->em->persist($notification);
        $this->em->flush();
    }

    public function update(Notification $notification, Array $data){
        if (isset($data['title']))
            $notification->setTitle($data['title']);
        if (isset($data['message']))
            $notification->setDescription($data['message']);
        if (isset($data['interaction']))
            $notification->setInteraction($data['interaction']);
        $this->em->persist($notification);
        $this->em->flush();
    }


}
?>