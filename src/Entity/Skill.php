<?php

namespace App\Entity;

use App\Repository\SkillRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SkillRepository::class)
 */
class Skill
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
    private $nom;

    /**
     * @ORM\Column(type="text")
     */
    private $xpRequiredForLevels;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=SkillUserXP::class, mappedBy="skill")
     */
    private $skillUserXPs;
    

    public function __construct()
    {
        $this->user = new ArrayCollection();
        $this->skillUserXPs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getXpRequiredForLevels(): ?string
    {
        return $this->xpRequiredForLevels;
    }

    public function setXpRequiredForLevels(string $xpRequiredForLevels): self
    {
        $this->xpRequiredForLevels = $xpRequiredForLevels;

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

    /**
     * @return Collection<int, SkillUserXP>
     */
    public function getSkillUserXPs(): Collection
    {
        return $this->skillUserXPs;
    }

    public function addSkillUserXP(SkillUserXP $skillUserXP): self
    {
        if (!$this->skillUserXPs->contains($skillUserXP)) {
            $this->skillUserXPs[] = $skillUserXP;
            $skillUserXP->setSkill($this);
        }

        return $this;
    }

    public function removeSkillUserXP(SkillUserXP $skillUserXP): self
    {
        if ($this->skillUserXPs->removeElement($skillUserXP)) {
            // set the owning side to null (unless already changed)
            if ($skillUserXP->getSkill() === $this) {
                $skillUserXP->setSkill(null);
            }
        }

        return $this;
    }

}
