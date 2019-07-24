<?php

namespace App\Controller;

use App\Entity\Orders;
use App\Entity\Player;
use App\Entity\Product;
use App\Entity\Team;
use App\Form\NewPlayerType;
use App\Service\CartManager;
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

            $selectedPlayer = $em->getRepository(Player::class)->findOneBy(['id' => $playerId]);
        }

        return $this->render('bar/index.html.twig', [
            'form' => $newplayerForm->createView(), 'teams' => $teams, 'selectedTeam' => $team, 'selectedPlayer' => $selectedPlayer, 'products' => $produits
        ]);
    }

    /**
     * @Route("/bar/addProduct/{product}/{player}", name="add_product")
     */
    public function addProduct(Product $product, CartManager $cartManager, string $player = null)
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
    public function resolveCart(Player $player, CartManager $cartManager)
    {
        $em = $this->getDoctrine()->getManager();


        $cart = $cartManager->getCart($player->getId());

        foreach ($cart['order'] as $prodId => $details) {
            /** @var Product $prod */
            $prod = $em->getRepository(Product::class)->find($prodId);
            $order = new Orders();
            $order->setPlayer($player);
            $order->setQuantity($details['quantity']);
            $order->setProduct($prod);
            $em->persist($order);
        }

        $em->flush();

        $cartManager->clearCart($player->getId());

        return $this->redirectToRoute("bar", ['teamName' => $player->getTeam()->getTeamName(), 'playerId' => $player->getId()]);
    }


    /**
     * @Route("/bar/clearCart/{id}", name="clear_cart")
     */
    public function clearCart(Player $player, CartManager $cartManager)
    {
        $cartManager->clearCart($player->getId());

        return $this->redirectToRoute("bar", ['teamName' => $player->getTeam()->getTeamName(), 'playerId' => $player->getId()]);
    }
}
