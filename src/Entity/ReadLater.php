<?php

namespace App\Entity;

use App\Repository\ReadLaterRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReadLaterRepository::class)
 */
class ReadLater
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $addDate;

    /**
     * @ORM\Column(type="integer")
     */
    private $positionOrder;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="readLaters")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Course::class, inversedBy="readLaters")
     */
    private $course;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddDate(): ?\DateTimeInterface
    {
        return $this->addDate;
    }

    public function setAddDate(\DateTimeInterface $addDate): self
    {
        $this->addDate = $addDate;

        return $this;
    }

    public function getPositionOrder(): ?int
    {
        return $this->positionOrder;
    }

    public function setPositionOrder(int $positionOrder): self
    {
        $this->positionOrder = $positionOrder;

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

    public function getCourse(): ?Course
    {
        return $this->course;
    }

    public function setCourse(?Course $course): self
    {
        $this->course = $course;

        return $this;
    }
}
