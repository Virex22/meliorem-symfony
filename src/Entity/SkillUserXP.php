<?php

namespace App\Entity;

use App\Repository\SkillUserXPRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;

/**
 * @ORM\Entity(repositoryClass=SkillUserXPRepository::class)
 */
class SkillUserXP
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $xp;

    /**
     * @ORM\ManyToOne(targetEntity=Skill::class, inversedBy="skillUserXPs")
     */
    private $skill;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="skillUserXPs")
     * @Ignore
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getXp(): ?int
    {
        return $this->xp;
    }

    public function setXp(int $xp): self
    {
        $this->xp = $xp;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
    public function getUserId(): ?int
    {
        if ($this->user == null)
            return null;
        return $this->user->getId();
    }
}
