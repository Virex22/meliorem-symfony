<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use App\DTO\UserDTO;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;

/**
 * @ORM\Entity(repositoryClass=ContactRepository::class)
 */
class Contact
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="contact") 
     * @Ignore
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=TypeContact::class, inversedBy="contacts")
     * @Ignore
     */
    private $typeContact;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

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

    public function getTypeContact(): ?TypeContact
    {
        return $this->typeContact;
    }

    public function setTypeContact(?TypeContact $typeContact): self
    {
        $this->typeContact = $typeContact;

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
    public function getTypeContactName(): ?string
    {
        if (!$this->typeContact) return null;
        return $this->typeContact->getName();
    }
    public function getUserId(): ?int
    {
        if (!$this->user) return null;
        return $this->user->getId();
    }
    public function getUserInfo(): ?array
    {
        if (!$this->user) return null;
        return [
            "email" => $this->user->getEmail(),
            "name" => $this->user->getName(),
            "firstname" => $this->user->getFirstname(),
            "image" => $this->user->getImage(),
        ];
    }
}
