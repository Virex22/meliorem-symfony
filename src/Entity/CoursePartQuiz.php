<?php

namespace App\Entity;

use App\Repository\CoursePartQuizRepository;
use App\Entity\CoursePart;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=CoursePartQuizRepository::class)
 */
class CoursePartQuiz
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Quiz::class, inversedBy="coursePartQuizzes")
     * @Ignore
     */
    private $quiz;

    /**
     * @ORM\OneToOne(targetEntity=CoursePart::class, inversedBy="coursePartQuiz", cascade={"persist", "remove"})
     * @Ignore
     */
    private $coursePart;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuiz(): ?Quiz
    {
        return $this->quiz;
    }

    public function setQuiz(?Quiz $quiz): self
    {
        $this->quiz = $quiz;

        return $this;
    }

    public function getCoursePart(): ?CoursePart
    {
        return $this->coursePart;
    }

    public function setCoursePart(?CoursePart $coursePart): self
    {
        $this->coursePart = $coursePart;

        return $this;
    }

    public function getQuizInfo(): ?array
    {
        if (!$this->quiz)
            return null;
        return [
            'id' => $this->quiz->getId(),
            'title' => $this->quiz->getTitle(),
            'description' => $this->quiz->getDescription(),
            'public' => $this->quiz->isPublic(),
            'createdAt' => $this->quiz->getCreatedAt(),
            'timeToPerformAll' => $this->quiz->getTimeToPerformAll()
        ];
    }

    public function getCoursePartInfo (): ?array
    {
        if (!$this->coursePart)
            return null;
        return [
            'id' => $this->coursePart->getId(),
            'title' => $this->coursePart->getTitle(),
            'orderPart' => $this->coursePart->getOrderPart(),
            'estimatedTime' => $this->coursePart->getEstimatedTime(),
        ];
    }


}
