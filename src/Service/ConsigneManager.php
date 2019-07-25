<?php


namespace App\Service;


use App\Contract\ConsigneManagerInterface;
use App\Entity\Player;
use Doctrine\ORM\EntityManagerInterface;

class ConsigneManager implements ConsigneManagerInterface
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function addConsigne(Player $player) :void
    {
        $player->setConsignes($player->getConsignes() + 1);
        $this->em->persist($player);
        $this->em->flush();
    }

    public function removeConsigne(Player $player) :void
    {
        $player->setConsignes($player->getConsignes() - 1);
        if ($player->getConsignes() >= 0) {
            $this->em->persist($player);
            $this->em->flush();
        }
    }
}
