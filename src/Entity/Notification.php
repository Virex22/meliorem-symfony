<?php

namespace App\Entity;

use App\Repository\NotificationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NotificationRepository::class)
 */
class Notification
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $interaction;

    /**
     * @ORM\OneToMany(targetEntity=ReceivedNotification::class, mappedBy="notification")
     */
    private $receivedNotifications;

    public function __construct()
    {
        $this->receivedNotifications = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getInteraction(): ?string
    {
        return $this->interaction;
    }

    public function setInteraction(?string $interaction): self
    {
        $this->interaction = $interaction;

        return $this;
    }

    /**
     * @return Collection<int, ReceivedNotification>
     */
    public function getReceivedNotifications(): Collection
    {
        return $this->receivedNotifications;
    }

    public function addReceivedNotification(ReceivedNotification $receivedNotification): self
    {
        if (!$this->receivedNotifications->contains($receivedNotification)) {
            $this->receivedNotifications[] = $receivedNotification;
            $receivedNotification->setNotification($this);
        }

        return $this;
    }

    public function removeReceivedNotification(ReceivedNotification $receivedNotification): self
    {
        if ($this->receivedNotifications->removeElement($receivedNotification)) {
            // set the owning side to null (unless already changed)
            if ($receivedNotification->getNotification() === $this) {
                $receivedNotification->setNotification(null);
            }
        }

        return $this;
    }
}
