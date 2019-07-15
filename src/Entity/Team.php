<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TeamRepository")
 */
class Team
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $role;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $token;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateToken;

    /**
     * @ORM\Column(type="boolean")
     */
    private $tokenActive;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Player", mappedBy="equipeId")
     */
    private $player;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Image", inversedBy="teamLogo", cascade={"persist", "remove"})
     */
    private $image;

    public function __construct()
    {
        $this->imageId = new ArrayCollection();
        $this->player = new ArrayCollection();
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

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
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

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getDateToken(): ?\DateTimeInterface
    {
        return $this->dateToken;
    }

    public function setDateToken(\DateTimeInterface $dateToken): self
    {
        $this->dateToken = $dateToken;

        return $this;
    }

    public function getTokenActive(): ?bool
    {
        return $this->tokenActive;
    }

    public function setTokenActive(bool $tokenActive): self
    {
        $this->tokenActive = $tokenActive;

        return $this;
    }

    /**
     * @return Collection|Player[]
     */
    public function getPlayer(): Collection
    {
        return $this->player;
    }

    public function addPlayer(Player $player): self
    {
        if (!$this->player->contains($player)) {
            $this->player[] = $player;
            $player->setEquipeId($this);
        }

        return $this;
    }

    public function removePlayer(Player $player): self
    {
        if ($this->player->contains($player)) {
            $this->player->removeElement($player);
            // set the owning side to null (unless already changed)
            if ($player->getEquipeId() === $this) {
                $player->setEquipeId(null);
            }
        }

        return $this;
    }

    public function getImageId(): ?Image
    {
        return $this->imageId;
    }

    public function setImageId(?Image $imageId): self
    {
        $this->imageId = $imageId;

        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): self
    {
        $this->image = $image;

        return $this;
    }
}
