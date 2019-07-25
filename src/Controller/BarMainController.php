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

class BarMainController extends AbstractController
{
    /**
     * @Route("/bar/main/{teamName}/{playerId}", name="bar")
     */
    public function index(Request $request, ObjectManager $em, string $teamName = null, string $playerId = null)
    {
        $player = new Player();
        $newplayerForm = $this->createForm(NewPlayerType::class, $player);
        $teams = $em->getRepository(Team::class)->findBy([], ['teamName' => 'ASC']);

        $produits = $em->getRepository(Product::class)->findAll();

        $selectedPlayer = "";
        $team = "";
        $newplayerForm->handleRequest($request);

        if($teamName != null) {
            $team = $em->getRepository(Team::class)->findOneBy(['teamName' => $teamName]);

            if ($newplayerForm->isSubmitted() && $newplayerForm->isValid()) {
                /** @var Team $team */
                $player->setTeam($team);
                $em->persist($player);
                $em->flush();

                return $this->redirectToRoute('bar', ['teamName' => $teamName]);
            }

            /** @var Player $selectedPlayer */
            $selectedPlayer = $em->getRepository(Player::class)->findOneBy(['id' => $playerId]);
        }

        return $this->render('bar/index.html.twig', [
            'form' => $newplayerForm->createView(), 'teams' => $teams, 'selectedTeam' => $team, 'selectedPlayer' => $selectedPlayer, 'products' => $produits
        ]);
    }


    /**
     * @Route("/bar/consigne/add/{player}", name="consigne_add")
     */
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
