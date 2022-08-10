<?php

namespace App\Entity;

use App\Repository\QuizPartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;


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
     * @ORM\Column(type="text")
     */
    private $answer;

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
     * @Ignore
     */
    private $quizPartPerforms;

    /**
     * @ORM\ManyToOne(targetEntity=Quiz::class, inversedBy="quizParts")
     * @Ignore
     */
    private $quiz;

    /**
     * @ORM\ManyToOne(targetEntity=Skill::class, inversedBy="competence")
     */
    private $skill;


    public function __construct()
    {
        $this->quizPartPerforms = new ArrayCollection();
    } 
    
    public function getQuizId(): ?int
    {
        if ($this->quiz != null)
            return $this->quiz->getId();
        return null;
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
     * Get the value of answer
     */ 
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Set the value of answer
     *
     * @return  self
     */ 
    public function setAnswer($answer)
    {
        $this->answer = $answer;

        return $this;
    }

    public function getSkill(): ?Skill
    {
        return $this->skill;
    }

    public function setSkill(?Skill $skill): self
    {
        $this->skill = $skill;

        return $this;
    }
}
