<?php

namespace App\Controller;

use App\Entity\Player;
use App\Entity\Product;
use App\Entity\Team;
use App\Form\NewPlayerType;
use App\Contract\CartManagerInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BarController extends AbstractController
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
     * @Route("/bar/addProduct/{product}/{player}", name="add_product")
     */
    public function addProduct(Product $product, CartManagerInterface $cartManager, string $player = null)
    {
        if ($player != null) {
            $player = $this->getDoctrine()->getRepository(Player::class)->find($player);
            /** @var Player $player */

            $cartManager->addToCart($product, $player->getId());
        }

        return $this->redirectToRoute("bar", ['teamName' => $player->getTeam()->getTeamName(), 'playerId' => $player->getId()]);
    }

    /**
     * @Route("/bar/resolveCart/{id}", name="resolve_cart")
     */
    public function resolveCart(Player $player, CartManagerInterface $cartManager)
    {
        $cartManager->resolveCart($player);

        return $this->redirectToRoute("bar", ['teamName' => $player->getTeam()->getTeamName(), 'playerId' => $player->getId()]);
    }


    /**
     * @Route("/bar/clearCart/{id}", name="clear_cart")
     */
    public function clearCart(Player $player, CartManagerInterface $cartManager)
    {
        $cartManager->clearCart($player->getId());

        return $this->redirectToRoute("bar", ['teamName' => $player->getTeam()->getTeamName(), 'playerId' => $player->getId()]);
    }
}
