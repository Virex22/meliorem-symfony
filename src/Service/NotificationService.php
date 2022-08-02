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
        if (!isset($notification['description']))
            throw new \Exception('Description is required');
        
        $notification = new Notification();
        $notification->setTitle($notification['title'])
            ->setDescription($notification['description']);

        if (isset($notification['interaction']))
            $notification->setInteraction($notification['interaction']);

        $this->em->persist($notification);
        $this->em->flush();
    }

    public function update(Notification $notification, Array $data){
        if (isset($data['title']))
            $notification->setTitle($data['title']);
        if (isset($data['description']))
            $notification->setDescription($data['description']);
        if (isset($data['interaction']))
            $notification->setInteraction($data['interaction']);
        $this->em->persist($notification);
        $this->em->flush();
    }


}
?>