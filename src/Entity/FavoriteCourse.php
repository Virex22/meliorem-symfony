<?php

namespace App\Entity;

use App\Repository\FavoriteCourseRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;

/**
 * @ORM\Entity(repositoryClass=FavoriteCourseRepository::class)
 */
class FavoriteCourse
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
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="favoriteCourses")
     * @Ignore
     */
    private $user;

    /**
     * @Ignore
     * @ORM\ManyToOne(targetEntity=Course::class, inversedBy="favoriteCourses")
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
    public function getUserInfo(): ?array
    {
        if (!$this->user)
            return null;
        return [
            'id' => $this->user->getId(),
            'name' => $this->user->getName(),
            'firstName' => $this->user->getFirstName(),
            'email' => $this->user->getEmail(),
            'roles' => $this->user->getRoles(),
        ];
    }
    public function getCourseInfo(): ?array
    {
        if (!$this->course)
            return null;
        return [
            'id' => $this->course->getId(),
            'title' => $this->course->getTitle(),
            'description' => $this->course->getDescription(),
            'image' => $this->course->getImage(),
        ];
    }
}
