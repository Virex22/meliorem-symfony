<?php

namespace App\Entity;

use App\Repository\CoursePartRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CoursePartRepository::class)
 */
class CoursePart
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
     * @ORM\Column(type="integer")
     */
    private $orderPart;

    /**
     * @ORM\Column(type="time")
     */
    private $estimatedTime;

    /**
     * @ORM\ManyToOne(targetEntity=CourseSection::class, inversedBy="courseParts")
     */
    private $courseSection;

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

    public function getOrderPart(): ?int
    {
        return $this->orderPart;
    }

    public function setOrderPart(int $orderPart): self
    {
        $this->orderPart = $orderPart;

        return $this;
    }

    public function getEstimatedTime(): ?\DateTimeInterface
    {
        return $this->estimatedTime;
    }

    public function setEstimatedTime(\DateTimeInterface $estimatedTime): self
    {
        $this->estimatedTime = $estimatedTime;

        return $this;
    }

    public function getCourseSection(): ?CourseSection
    {
        return $this->courseSection;
    }

    public function setCourseSection(?CourseSection $courseSection): self
    {
        $this->courseSection = $courseSection;

        return $this;
    }
}
