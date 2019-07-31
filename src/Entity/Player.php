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
     * @ORM\ManyToOne(targetEntity="App\Entity\Team", inversedBy="players")
     */
    private $team;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Orders", mappedBy="player")
     */
    private $orders;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Image")
     */
    private $picture;

    /**
     * @ORM\Column(type="integer")
     */
    private $consignes = 0;

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

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): self
    {
        $this->team = $team;

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
            $order->setPlayer($this);
        }

        return $this;
    }

    public function removeOrder(Orders $order): self
    {
        if ($this->orders->contains($order)) {
            $this->orders->removeElement($order);
            // set the owning side to null (unless already changed)
            if ($order->getPlayer() === $this) {
                $order->setPlayer(null);
            }
        }

        return $this;
    }

    public function getPicture(): ?Image
    {
        return $this->picture;
    }

    public function setPicture(?Image $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    // Permet de récupérer la somme due par un joueur
    public function getDueCheck() :float
    {
        $total = 0;
        foreach ($this->getOrders() as $order) {
            $total += $order->getQuantity() * $order->getProduct()->getPrice();
        }

        return $total;
    }

    public function getConsignes(): ?int
    {
        return $this->consignes;
    }

    public function setConsignes(int $consignes): self
    {
        $this->consignes = $consignes;

        return $this;
    }
}
