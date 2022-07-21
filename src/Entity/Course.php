<?php

namespace App\Entity;

use App\Repository\CourseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CourseRepository::class)
 */
class Course
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
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $publishDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $lastEditDate;

    /**
     * @ORM\Column(type="text")
     */
    private $image;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPublic;

    /**
     * @ORM\OneToMany(targetEntity=FavoriteCourse::class, mappedBy="course")
     */
    private $favoriteCourses;

    /**
     * @ORM\OneToMany(targetEntity=ReadLater::class, mappedBy="course")
     */
    private $readLaters;

    /**
     * @ORM\ManyToOne(targetEntity=Speaker::class, inversedBy="courses")
     */
    private $speaker;

    /**
     * @ORM\ManyToMany(targetEntity=Group::class, inversedBy="courses")
     */
    private $groupFilter;

    /**
     * @ORM\OneToMany(targetEntity=CourseSection::class, mappedBy="course")
     */
    private $courseSections;

    /**
     * @ORM\ManyToMany(targetEntity=CourseCategory::class, inversedBy="courses")
     */
    private $category;

    public function __construct()
    {
        $this->favoriteCourses = new ArrayCollection();
        $this->readLaters = new ArrayCollection();
        $this->groupFilter = new ArrayCollection();
        $this->courseSections = new ArrayCollection();
        $this->category = new ArrayCollection();
    }

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPublishDate(): ?\DateTimeInterface
    {
        return $this->publishDate;
    }

    public function setPublishDate(\DateTimeInterface $publishDate): self
    {
        $this->publishDate = $publishDate;

        return $this;
    }

    public function getLastEditDate(): ?\DateTimeInterface
    {
        return $this->lastEditDate;
    }

    public function setLastEditDate(\DateTimeInterface $lastEditDate): self
    {
        $this->lastEditDate = $lastEditDate;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function isIsPublic(): ?bool
    {
        return $this->isPublic;
    }

    public function setIsPublic(bool $isPublic): self
    {
        $this->isPublic = $isPublic;

        return $this;
    }

    /**
     * @return Collection<int, FavoriteCourse>
     */
    public function getFavoriteCourses(): Collection
    {
        return $this->favoriteCourses;
    }

    public function addFavoriteCourse(FavoriteCourse $favoriteCourse): self
    {
        if (!$this->favoriteCourses->contains($favoriteCourse)) {
            $this->favoriteCourses[] = $favoriteCourse;
            $favoriteCourse->setCourse($this);
        }

        return $this;
    }

    public function removeFavoriteCourse(FavoriteCourse $favoriteCourse): self
    {
        if ($this->favoriteCourses->removeElement($favoriteCourse)) {
            // set the owning side to null (unless already changed)
            if ($favoriteCourse->getCourse() === $this) {
                $favoriteCourse->setCourse(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ReadLater>
     */
    public function getReadLaters(): Collection
    {
        return $this->readLaters;
    }

    public function addReadLater(ReadLater $readLater): self
    {
        if (!$this->readLaters->contains($readLater)) {
            $this->readLaters[] = $readLater;
            $readLater->setCourse($this);
        }

        return $this;
    }

    public function removeReadLater(ReadLater $readLater): self
    {
        if ($this->readLaters->removeElement($readLater)) {
            // set the owning side to null (unless already changed)
            if ($readLater->getCourse() === $this) {
                $readLater->setCourse(null);
            }
        }

        return $this;
    }

    public function getSpeaker(): ?Speaker
    {
        return $this->speaker;
    }

    public function setSpeaker(?Speaker $speaker): self
    {
        $this->speaker = $speaker;

        return $this;
    }

    /**
     * @return Collection<int, Group>
     */
    public function getGroupFilter(): Collection
    {
        return $this->groupFilter;
    }

    public function addGroupFilter(Group $groupFilter): self
    {
        if (!$this->groupFilter->contains($groupFilter)) {
            $this->groupFilter[] = $groupFilter;
        }

        return $this;
    }

    public function removeGroupFilter(Group $groupFilter): self
    {
        $this->groupFilter->removeElement($groupFilter);

        return $this;
    }

    /**
     * @return Collection<int, CourseSection>
     */
    public function getCourseSections(): Collection
    {
        return $this->courseSections;
    }

    public function addCourseSection(CourseSection $courseSection): self
    {
        if (!$this->courseSections->contains($courseSection)) {
            $this->courseSections[] = $courseSection;
            $courseSection->setCourse($this);
        }

        return $this;
    }

    public function removeCourseSection(CourseSection $courseSection): self
    {
        if ($this->courseSections->removeElement($courseSection)) {
            // set the owning side to null (unless already changed)
            if ($courseSection->getCourse() === $this) {
                $courseSection->setCourse(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CourseCategory>
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function addCategory(CourseCategory $category): self
    {
        if (!$this->category->contains($category)) {
            $this->category[] = $category;
        }

        return $this;
    }

    public function removeCategory(CourseCategory $category): self
    {
        $this->category->removeElement($category);

        return $this;
    }
}
