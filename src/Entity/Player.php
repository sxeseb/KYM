<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlayerRepository")
 */
class Player
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Team", inversedBy="imageId")
     */
    private $equipe;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Image", inversedBy="player", cascade={"persist", "remove"})
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity="Orders", mappedBy="playerId")
     */
    private $orders;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
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

    public function getEquipeId(): ?Team
    {
        return $this->equipeId;
    }

    public function setEquipeId(?Team $equipeId): self
    {
        $this->equipeId = $equipeId;

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

    /**
     * @return Collection|Orders[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Orders $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setPlayerId($this);
        }

        return $this;
    }

    public function removeOrder(Orders $order): self
    {
        if ($this->orders->contains($order)) {
            $this->orders->removeElement($order);
            // set the owning side to null (unless already changed)
            if ($order->getPlayerId() === $this) {
                $order->setPlayerId(null);
            }
        }

        return $this;
    }

    public function getEquipe(): ?Team
    {
        return $this->equipe;
    }

    public function setEquipe(?Team $equipe): self
    {
        $this->equipe = $equipe;

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
