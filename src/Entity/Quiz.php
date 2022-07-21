<?php

namespace App\Entity;

use App\Repository\QuizRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuizRepository::class)
 */
class Quiz
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
    private $description;

    /**
     * @ORM\Column(type="boolean")
     */
    private $public;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="time")
     */
    private $timeToPerformAll;

    /**
     * @ORM\OneToMany(targetEntity=QuizPart::class, mappedBy="quiz")
     */
    private $quizParts;

    /**
     * @ORM\OneToMany(targetEntity=CoursePartQuiz::class, mappedBy="quiz")
     */
    private $coursePartQuizzes;

    public function __construct()
    {
        $this->quizParts = new ArrayCollection();
        $this->coursePartQuizzes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function isPublic(): ?bool
    {
        return $this->public;
    }

    public function setPublic(bool $public): self
    {
        $this->public = $public;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getTimeToPerformAll(): ?\DateTimeInterface
    {
        return $this->timeToPerformAll;
    }

    public function setTimeToPerformAll(\DateTimeInterface $timeToPerformAll): self
    {
        $this->timeToPerformAll = $timeToPerformAll;

        return $this;
    }

    /**
     * @return Collection<int, QuizPart>
     */
    public function getQuizParts(): Collection
    {
        return $this->quizParts;
    }

    public function addQuizPart(QuizPart $quizPart): self
    {
        if (!$this->quizParts->contains($quizPart)) {
            $this->quizParts[] = $quizPart;
            $quizPart->setQuiz($this);
        }

        return $this;
    }

    public function removeQuizPart(QuizPart $quizPart): self
    {
        if ($this->quizParts->removeElement($quizPart)) {
            // set the owning side to null (unless already changed)
            if ($quizPart->getQuiz() === $this) {
                $quizPart->setQuiz(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CoursePartQuiz>
     */
    public function getCoursePartQuizzes(): Collection
    {
        return $this->coursePartQuizzes;
    }

    public function addCoursePartQuiz(CoursePartQuiz $coursePartQuiz): self
    {
        if (!$this->coursePartQuizzes->contains($coursePartQuiz)) {
            $this->coursePartQuizzes[] = $coursePartQuiz;
            $coursePartQuiz->setQuiz($this);
        }

        return $this;
    }

    public function removeCoursePartQuiz(CoursePartQuiz $coursePartQuiz): self
    {
        if ($this->coursePartQuizzes->removeElement($coursePartQuiz)) {
            // set the owning side to null (unless already changed)
            if ($coursePartQuiz->getQuiz() === $this) {
                $coursePartQuiz->setQuiz(null);
            }
        }

        return $this;
    }
}
