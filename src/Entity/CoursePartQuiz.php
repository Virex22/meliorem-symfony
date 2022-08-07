<?php

namespace App\Entity;

use App\Repository\CoursePartQuizRepository;
use App\Entity\CoursePart;
use Doctrine\ORM\Mapping as ORM;

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
     */
    private $quiz;

    /**
     * @ORM\OneToOne(targetEntity=CoursePart::class, inversedBy="coursePartQuiz", cascade={"persist", "remove"})
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


}
