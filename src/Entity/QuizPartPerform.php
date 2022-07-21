<?php

namespace App\Entity;

use App\Repository\QuizPartPerformRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuizPartPerformRepository::class)
 */
class QuizPartPerform
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="time")
     */
    private $timeToResponse;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="integer")
     */
    private $score;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="quizPartPerforms")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=QuizPart::class, inversedBy="quizPartPerforms")
     */
    private $quizPart;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTimeToResponse(): ?\DateTimeInterface
    {
        return $this->timeToResponse;
    }

    public function setTimeToResponse(\DateTimeInterface $timeToResponse): self
    {
        $this->timeToResponse = $timeToResponse;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): self
    {
        $this->score = $score;

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

    public function getQuizPart(): ?QuizPart
    {
        return $this->quizPart;
    }

    public function setQuizPart(?QuizPart $quizPart): self
    {
        $this->quizPart = $quizPart;

        return $this;
    }
}
