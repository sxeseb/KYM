<?php

namespace App\Controller;

use App\Contract\ConsigneManagerInterface;
use App\Entity\Player;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BarConsigneController extends AbstractController
{
    private $consigneManager;

    public function __construct(ConsigneManagerInterface $consigneManager)
    {
        $this->consigneManager = $consigneManager;
    }

    /**
     * @Route("/bar/consigne/add/{player}", name="consigne_add")
     */
    public function addConsigne(int $player = null)
    {
        $playerId = "";
        $team = "";

        if ($player != null) {
            /** @var Player $player */
            $player = $this->getDoctrine()->getRepository(Player::class)->find($player);

            $this->consigneManager->addConsigne($player);

            $team = $player->getTeam()->getTeamName();
            $playerId = $player->getId();
        }

        return $this->redirectToRoute("bar", ['teamName' => $team, 'playerId' => $playerId]);
    }

    /**
     * @Route("/bar/consigne/remove/{player}", name="consigne_remove")
     */
    public function removeConsigne(int $player = null)
    {
        $playerId = "";
        $team = "";

        if ($player != null) {
            /** @var Player $player */
            $player = $this->getDoctrine()->getRepository(Player::class)->find($player);

            $this->consigneManager->removeConsigne($player);

            $team = $player->getTeam()->getTeamName();
            $playerId = $player->getId();
        }

        return $this->redirectToRoute("bar", ['teamName' => $team, 'playerId' => $playerId]);
    }
}
