<?php

namespace App\Entity;

use App\Repository\QuizPartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuizPartRepository::class)
 */
class QuizPart
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
    private $question;

    /**
     * @ORM\Column(type="text")
     */
    private $choice;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $timeMaxToResponse;

    /**
     * @ORM\Column(type="integer")
     */
    private $quizOrder;

    /**
     * @ORM\OneToMany(targetEntity=QuizPartPerform::class, mappedBy="quizPart")
     */
    private $quizPartPerforms;

    /**
     * @ORM\ManyToOne(targetEntity=Quiz::class, inversedBy="quizParts")
     */
    private $quiz;

    /**
     * @ORM\ManyToMany(targetEntity=Skill::class, inversedBy="quizParts")
     */
    private $valideCompetence;

    public function __construct()
    {
        $this->quizPartPerforms = new ArrayCollection();
        $this->valideCompetence = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getChoice(): ?string
    {
        return $this->choice;
    }

    public function setChoice(string $choice): self
    {
        $this->choice = $choice;

        return $this;
    }

    public function getTimeMaxToResponse(): ?int
    {
        return $this->timeMaxToResponse;
    }

    public function setTimeMaxToResponse(int $timeMaxToResponse): self
    {
        $this->timeMaxToResponse = $timeMaxToResponse;

        return $this;
    }

    public function getQuizOrder(): ?int
    {
        return $this->quizOrder;
    }

    public function setQuizOrder(int $quizOrder): self
    {
        $this->quizOrder = $quizOrder;

        return $this;
    }

    /**
     * @return Collection<int, QuizPartPerform>
     */
    public function getQuizPartPerforms(): Collection
    {
        return $this->quizPartPerforms;
    }

    public function addQuizPartPerform(QuizPartPerform $quizPartPerform): self
    {
        if (!$this->quizPartPerforms->contains($quizPartPerform)) {
            $this->quizPartPerforms[] = $quizPartPerform;
            $quizPartPerform->setQuizPart($this);
        }

        return $this;
    }

    public function removeQuizPartPerform(QuizPartPerform $quizPartPerform): self
    {
        if ($this->quizPartPerforms->removeElement($quizPartPerform)) {
            // set the owning side to null (unless already changed)
            if ($quizPartPerform->getQuizPart() === $this) {
                $quizPartPerform->setQuizPart(null);
            }
        }

        return $this;
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

    /**
     * @return Collection<int, Skill>
     */
    public function getValideCompetence(): Collection
    {
        return $this->valideCompetence;
    }

    public function addValideCompetence(Skill $valideCompetence): self
    {
        if (!$this->valideCompetence->contains($valideCompetence)) {
            $this->valideCompetence[] = $valideCompetence;
        }

        return $this;
    }

    public function removeValideCompetence(Skill $valideCompetence): self
    {
        $this->valideCompetence->removeElement($valideCompetence);

        return $this;
    }
}
