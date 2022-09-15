<?php

namespace App\Entity;

use App\Repository\CoursePartDocumentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=CoursePartDocumentRepository::class)
 */
class CoursePartDocument
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $linkVideo;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $files;

    /**
     * @ORM\OneToOne(targetEntity=CoursePart::class, inversedBy="coursePartDocument", cascade={"persist", "remove"})
     * @Ignore
     */
    private $coursePart;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLinkVideo(): ?string
    {
        return $this->linkVideo;
    }

    public function setLinkVideo(?string $linkVideo): self
    {
        $this->linkVideo = $linkVideo;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getFiles(): ?string
    {
        return $this->files;
    }

    public function setFiles(?string $files): self
    {
        $this->files = $files;

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

    public function getCoursePartInfo(): ?array
    {
        if ($this->coursePart) {
            return [
                'id' => $this->coursePart->getId(),
                'title' => $this->coursePart->getTitle(),
                'orderPart' => $this->coursePart->getOrderPart(),
                'estimatedTime' => $this->coursePart->getEstimatedTime(),
                'courseSectionInfo' => $this->coursePart->getCourseSectionInfo(),
            ];
        }
        return null;
    }
}
