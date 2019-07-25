<?php

namespace App\Controller;

use App\Entity\Player;
use App\Entity\Product;
use App\Entity\Team;
use App\Form\NewPlayerType;
use App\Service\ConsigneManager;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BarConsigneController extends AbstractController
{
    public function addConsigne(ConsigneManager $consigneManager, int $player = null)
    {
        $playerId = "";
        $team = "";

        if ($player != null) {
            /** @var Player $player */
            $player = $this->getDoctrine()->getRepository(Player::class)->find($player);

            $consigneManager->addConsigne($player);

            $team = $player->getTeam()->getTeamName();
            $playerId = $player->getId();
        }

        return $this->redirectToRoute("bar", ['teamName' => $team, 'playerId' => $playerId]);
    }

    /**
     * @Route("/bar/consigne/remove/{player}", name="consigne_remove")
     */
    public function removeConsigne(ConsigneManager $consigneManager, int $player = null)
    {
        $playerId = "";
        $team = "";

        if ($player != null) {
            /** @var Player $player */
            $player = $this->getDoctrine()->getRepository(Player::class)->find($player);

            $consigneManager->removeConsigne($player);

            $team = $player->getTeam()->getTeamName();
            $playerId = $player->getId();
        }

        return $this->redirectToRoute("bar", ['teamName' => $team, 'playerId' => $playerId]);
    }
}
