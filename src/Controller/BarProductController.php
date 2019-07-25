<?php


namespace App\Controller;

use App\Contract\CartManagerInterface;
use App\Entity\Player;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BarProductController extends AbstractController
{

    /**
     * @Route("/bar/addProduct/{product}/{player}", name="add_product")
     */
    public function addProduct(Product $product, CartManagerInterface $cartManager, int $player = null)
    {
        $playerId = "";
        $team = "";

        if ($player != null) {
            $player = $this->getDoctrine()->getRepository(Player::class)->find($player);
            /** @var Player $player */
            $cartManager->addToCart($product, $player->getId());

            $team = $player->getTeam()->getTeamName();
            $playerId = $player->getId();
        }

        return $this->redirectToRoute("bar", ['teamName' => $team, 'playerId' => $playerId]);
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
