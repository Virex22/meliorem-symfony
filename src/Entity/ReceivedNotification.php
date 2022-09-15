<?php

namespace App\Entity;

use App\Repository\ReceivedNotificationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=ReceivedNotificationRepository::class)
 */
class ReceivedNotification
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $viewed;

    /**
     * @ORM\ManyToOne(targetEntity=Notification::class, inversedBy="receivedNotifications")
     */
    private $notification;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="receivedNotifications")
     * @Ignore
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isViewed(): ?bool
    {
        return $this->viewed;
    }

    public function setViewed(bool $viewed): self
    {
        $this->viewed = $viewed;

        return $this;
    }

    public function getNotification(): ?Notification
    {
        return $this->notification;
    }

    public function setNotification(?Notification $notification): self
    {
        $this->notification = $notification;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getUserId(): ?int
    {
        if ($this->user === null)
            return null;
        return $this->user->getId();
    }
}
