<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;

/**
 * @ORM\Entity(repositoryClass=StudentRepository::class)
 */
class Student
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    
    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="Student", cascade={"persist", "remove"})
     * @Ignore
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Group::class, inversedBy="Student")
     */
    private $groupReference;

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

    public function getGroupReference(): ?Group
    {
        return $this->groupReference;
    }

    public function setGroupReference(?Group $groupReference): self
    {
        $this->groupReference = $groupReference;

        return $this;
    }

    /**
     * Get auto user id
     */ 
    public function getUserId()
    {
        return $this->user->getId();
    }
}
