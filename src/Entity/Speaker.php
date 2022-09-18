<?php

namespace App\Entity;

use App\Repository\SpeakerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;

/**
 * @ORM\Entity(repositoryClass=SpeakerRepository::class)
 */
class Speaker
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="speaker", cascade={"persist", "remove"})
     * @Ignore
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Speciality::class, mappedBy="speaker")
     */
    private $specialities;

    /**
     * @ORM\OneToMany(targetEntity=Course::class, mappedBy="speaker")
     * @Ignore
     */
    private $courses;

    /**
     * @ORM\OneToMany(targetEntity=Quiz::class, mappedBy="speaker")
     * @Ignore
     */
    private $quizzes;

    public function __construct()
    {
        $this->specialities = new ArrayCollection();
        $this->courses = new ArrayCollection();
        $this->quizzes = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, Speciality>
     */
    public function getSpecialities(): Collection
    {
        return $this->specialities;
    }

    public function addSpeciality(Speciality $speciality): self
    {
        if (!$this->specialities->contains($speciality)) {
            $this->specialities[] = $speciality;
            $speciality->setSpeaker($this);
        }

        return $this;
    }

    public function removeSpeciality(Speciality $speciality): self
    {
        if ($this->specialities->removeElement($speciality)) {
            // set the owning side to null (unless already changed)
            if ($speciality->getSpeaker() === $this) {
                $speciality->setSpeaker(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Course>
     */
    public function getCourses(): Collection
    {
        return $this->courses;
    }

    public function addCourse(Course $course): self
    {
        if (!$this->courses->contains($course)) {
            $this->courses[] = $course;
            $course->setSpeaker($this);
        }

        return $this;
    }

    public function removeCourse(Course $course): self
    {
        if ($this->courses->removeElement($course)) {
            // set the owning side to null (unless already changed)
            if ($course->getSpeaker() === $this) {
                $course->setSpeaker(null);
            }
        }

        return $this;
    }
    public function getSpecialitiesId(): array
    {
        $specialitiesId = [];
        foreach ($this->specialities as $speciality)
            $specialitiesId[] = $speciality->getId();
        return $specialitiesId;
    }

    /**
     * @return Collection<int, Quiz>
     */
    public function getQuizzes(): Collection
    {
        return $this->quizzes;
    }

    public function addQuiz(Quiz $quiz): self
    {
        if (!$this->quizzes->contains($quiz)) {
            $this->quizzes[] = $quiz;
            $quiz->setSpeaker($this);
        }

        return $this;
    }

    public function removeQuiz(Quiz $quiz): self
    {
        if ($this->quizzes->removeElement($quiz)) {
            // set the owning side to null (unless already changed)
            if ($quiz->getSpeaker() === $this) {
                $quiz->setSpeaker(null);
            }
        }

        return $this;
    }

    public function getUserInfo(): array
    {
        return [
            'id' => $this->user->getId(),
            'firstName' => $this->user->getFirstName(),
            'name' => $this->user->getName(),
            'email' => $this->user->getEmail(),
        ];
    }

    public function getCoursesId(): array
    {
        $coursesId = [];
        foreach ($this->courses as $course)
            $coursesId[] = $course->getId();
        return $coursesId;
    }

    public function getQuizzesId(): array
    {
        $quizzesId = [];
        foreach ($this->quizzes as $quiz)
            $quizzesId[] = $quiz->getId();
        return $quizzesId;
    }
}
