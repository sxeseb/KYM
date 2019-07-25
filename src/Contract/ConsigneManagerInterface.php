<?php


namespace App\Contract;


use App\Entity\Player;

interface ConsigneManagerInterface
{
    /**
     * ajout d'une consigne au joueur
     */
    public function addConsigne(Player $player) :void;

    /**
     * soustraction d'une consigne au joueur
     */
    public function removeConsigne(Player $player) :void;
}
