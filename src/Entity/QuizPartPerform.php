<?php

namespace App\Entity;

use App\Repository\QuizPartPerformRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;

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
     * @ORM\Column(type="integer")
     * in seconds
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
     * @Ignore
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

    public function getTimeToResponse(): ?int
    {
        return $this->timeToResponse;
    }

    public function setTimeToResponse(int $timeToResponse): self
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
    public function getUserId(): ?int
    {
        if ($this->user) {
            return $this->user->getId();
        }
        return null;
    }
}
