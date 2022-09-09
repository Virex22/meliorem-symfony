<?php

namespace App\Entity;

use App\Repository\GroupRepository;
use App\Entity\Student;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;

/**
 * @ORM\Entity(repositoryClass=GroupRepository::class)
 * @ORM\Table(name="`group`")
 */
class Group
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Student::class, mappedBy="group")
     * @Ignore
     */
    private $student;

    /**
     * @ORM\ManyToMany(targetEntity=Course::class, mappedBy="group")
     * @Ignore
     */
    private $courses;

    public function __construct()
    {
        $this->student = new ArrayCollection();
        $this->courses = new ArrayCollection();
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

    /**
     * @return Collection<int, Student>
     */
    public function getStudent(): Collection
    {
        return $this->student;
    }

    public function addStudent(Student $student): self
    {
        if (!$this->student->contains($student)) {
            $this->student[] = $student;
            $student->setGroup($this);
        }

        return $this;
    }

    public function removeStudent(Student $student): self
    {
        if ($this->student->removeElement($student)) {
            // set the owning side to null (unless already changed)
            if ($student->getGroup() === $this) {
                $student->setGroup(null);
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
            $course->addGroup($this);
        }

        return $this;
    }

    public function removeCourse(Course $course): self
    {
        if ($this->courses->removeElement($course)) {
            $course->removeGroup($this);
        }

        return $this;
    }
    public function getStudentInfo() : ?array
    {
        $studentInfo = [];
        foreach ($this->student as $student) {
            $studentInfo[] = [
                'id' => $student->getId(),
                'name' => $student->getUser()->getName()
            ];
        }
        return $studentInfo;
    }
    public function getCoursesInfo() : ?array
    {
        $coursesInfo = [];
        foreach ($this->courses as $course) {
            $coursesInfo[] = [
                'id' => $course->getId(),
                'title' => $course->getTitle()
            ];
        }
        return $coursesInfo;
    }
    public function getStudentCount() : int
    {
        return count($this->student);
    }
}
