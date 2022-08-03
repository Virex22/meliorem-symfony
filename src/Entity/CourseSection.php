<?php

namespace App\Entity;

use App\Repository\CourseSectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CourseSectionRepository::class)
 */
class CourseSection
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
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $courseOrder;

    /**
     * @ORM\ManyToOne(targetEntity=Course::class, inversedBy="courseSections")
     */
    private $course;

    /**
     * @ORM\OneToMany(targetEntity=CoursePart::class, mappedBy="courseSection")
     */
    private $courseParts;

    public function __construct()
    {
        $this->courseParts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCourseOrder(): ?int
    {
        return $this->courseOrder;
    }

    public function setCourseOrder(int $courseOrder): self
    {
        $this->courseOrder = $courseOrder;

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

    /**
     * @return Collection<int, CoursePart>
     */
    public function getCourseParts(): Collection
    {
        return $this->courseParts;
    }

    public function addCoursePart(CoursePart $coursePart): self
    {
        if (!$this->courseParts->contains($coursePart)) {
            $this->courseParts[] = $coursePart;
            $coursePart->setCourseSection($this);
        }

        return $this;
    }

    public function removeCoursePart(CoursePart $coursePart): self
    {
        if ($this->courseParts->removeElement($coursePart)) {
            // set the owning side to null (unless already changed)
            if ($coursePart->getCourseSection() === $this) {
                $coursePart->setCourseSection(null);
            }
        }

        return $this;
    }
}
