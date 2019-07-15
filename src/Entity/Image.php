<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ImageRepository")
 */
class Image
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
    private $src;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Player", mappedBy="imageId", cascade={"persist", "remove"})
     */
    private $player;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Team", mappedBy="imageId", cascade={"persist", "remove"})
     */
    private $teamLogo;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Product", mappedBy="imageId", cascade={"persist", "remove"})
     */
    private $product;

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

    public function getSrc(): ?string
    {
        return $this->src;
    }

    public function setSrc(string $src): self
    {
        $this->src = $src;

        return $this;
    }

    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    public function setPlayer(?Player $player): self
    {
        $this->player = $player;

        // set (or unset) the owning side of the relation if necessary
        $newImage = $player === null ? null : $this;
        if ($newImage !== $player->getImage()) {
            $player->setImage($newImage);
        }

        return $this;
    }

    public function getTeamLogo(): ?Team
    {
        return $this->teamLogo;
    }

    public function setTeamLogo(?Team $teamLogo): self
    {
        $this->teamLogo = $teamLogo;

        // set (or unset) the owning side of the relation if necessary
        $newImage = $teamLogo === null ? null : $this;
        if ($newImage !== $teamLogo->getImage()) {
            $teamLogo->setImage($newImage);
        }

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        // set (or unset) the owning side of the relation if necessary
        $newImage = $product === null ? null : $this;
        if ($newImage !== $product->getImage()) {
            $product->setImage($newImage);
        }

        return $this;
    }
}
