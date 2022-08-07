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
     * @ORM\Column(type="integer")
     */
    private $estimatedTime;

    /**
     * @ORM\ManyToOne(targetEntity=CourseSection::class, inversedBy="courseParts")
     */
    private $courseSection;

    /**
     * @ORM\OneToOne(targetEntity=CoursePartDocument::class, mappedBy="coursePart", cascade={"persist", "remove"})
     */
    private $coursePartDocument;

    /**
     * @ORM\OneToOne(targetEntity=CoursePartQuiz::class, mappedBy="coursePart", cascade={"persist", "remove"})
     */
    private $coursePartQuiz;




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

    public function getEstimatedTime(): ?int
    {
        return $this->estimatedTime;
    }

    public function setEstimatedTime(int $estimatedTime): self
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

    public function getCoursePartDocument(): ?CoursePartDocument
    {
        return $this->coursePartDocument;
    }

    public function setCoursePartDocument(?CoursePartDocument $coursePartDocument): self
    {
        // unset the owning side of the relation if necessary
        if ($coursePartDocument === null && $this->coursePartDocument !== null) {
            $this->coursePartDocument->setCoursePart(null);
        }

        // set the owning side of the relation if necessary
        if ($coursePartDocument !== null && $coursePartDocument->getCoursePart() !== $this) {
            $coursePartDocument->setCoursePart($this);
        }

        $this->coursePartDocument = $coursePartDocument;

        return $this;
    }

    public function getCoursePartQuiz(): ?CoursePartQuiz
    {
        return $this->coursePartQuiz;
    }

    public function setCoursePartQuiz(?CoursePartQuiz $coursePartQuiz): self
    {
        // unset the owning side of the relation if necessary
        if ($coursePartQuiz === null && $this->coursePartQuiz !== null) {
            $this->coursePartQuiz->setCoursePart(null);
        }

        // set the owning side of the relation if necessary
        if ($coursePartQuiz !== null && $coursePartQuiz->getCoursePart() !== $this) {
            $coursePartQuiz->setCoursePart($this);
        }

        $this->coursePartQuiz = $coursePartQuiz;

        return $this;
    }
}
