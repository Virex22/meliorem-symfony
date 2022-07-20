<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToOne(targetEntity=Contact::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $contact;

    /**
     * @ORM\OneToMany(targetEntity=ReceivedNotification::class, mappedBy="user")
     */
    private $receivedNotifications;

    /**
     * @ORM\OneToOne(targetEntity=Student::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $student;

    /**
     * @ORM\Column(type="text")
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $firstname;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $image;

    /**
     * @ORM\ManyToMany(targetEntity=Badge::class, mappedBy="user")
     */
    private $badges;

    /**
     * @ORM\OneToMany(targetEntity=SkillUserXP::class, mappedBy="user")
     */
    private $skillUserXPs;


    public function __construct()
    {
        $this->receivedNotifications = new ArrayCollection();
        $this->badges = new ArrayCollection();
        $this->skills = new ArrayCollection();
        $this->skillUserXPs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    public function setContact(?Contact $contact): self
    {
        // unset the owning side of the relation if necessary
        if ($contact === null && $this->contact !== null) {
            $this->contact->setUser(null);
        }

        // set the owning side of the relation if necessary
        if ($contact !== null && $contact->getUser() !== $this) {
            $contact->setUser($this);
        }

        $this->contact = $contact;

        return $this;
    }

    /**
     * @return Collection<int, ReceivedNotification>
     */
    public function getReceivedNotifications(): Collection
    {
        return $this->receivedNotifications;
    }

    public function addReceivedNotification(ReceivedNotification $receivedNotification): self
    {
        if (!$this->receivedNotifications->contains($receivedNotification)) {
            $this->receivedNotifications[] = $receivedNotification;
            $receivedNotification->setUser($this);
        }

        return $this;
    }

    public function removeReceivedNotification(ReceivedNotification $receivedNotification): self
    {
        if ($this->receivedNotifications->removeElement($receivedNotification)) {
            // set the owning side to null (unless already changed)
            if ($receivedNotification->getUser() === $this) {
                $receivedNotification->setUser(null);
            }
        }

        return $this;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): self
    {
        // unset the owning side of the relation if necessary
        if ($student === null && $this->student !== null) {
            $this->student->setUser(null);
        }

        // set the owning side of the relation if necessary
        if ($student !== null && $student->getUser() !== $this) {
            $student->setUser($this);
        }

        $this->Student = $student;

        return $this;
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

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, Badge>
     */
    public function getBadges(): Collection
    {
        return $this->badges;
    }

    public function addBadge(Badge $badge): self
    {
        if (!$this->badges->contains($badge)) {
            $this->badges[] = $badge;
            $badge->addUser($this);
        }

        return $this;
    }

    public function removeBadge(Badge $badge): self
    {
        if ($this->badges->removeElement($badge)) {
            $badge->removeUser($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Skill>
     */
    public function getSkills(): Collection
    {
        return $this->skills;
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
            $skillUserXP->setUser($this);
        }

        return $this;
    }

    public function removeSkillUserXP(SkillUserXP $skillUserXP): self
    {
        if ($this->skillUserXPs->removeElement($skillUserXP)) {
            // set the owning side to null (unless already changed)
            if ($skillUserXP->getUser() === $this) {
                $skillUserXP->setUser(null);
            }
        }

        return $this;
    }
}
