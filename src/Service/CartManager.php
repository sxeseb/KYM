<?php

namespace App\Service;

use App\Contract\CartManagerInterface;
use App\Entity\Orders;
use App\Entity\Player;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartManager implements CartManagerInterface
{
    private $session;
    private $em;

    public function __construct(SessionInterface $session, EntityManagerInterface $em)
    {
        $this->session = $session;
        $this->em = $em;
    }

    public function initCart() :array
    {
        $playerCart = [
            'total' => 0,
            'order' => []
        ];

        return $playerCart;
    }

    public function addToCart(Product $product, int $playerId) :void
    {
        $cart = $this->session->get($playerId, $this->initCart());

        if (key_exists($product->getId(), $cart['order'])) {
            $cart['order'][$product->getId()]['quantity'] += 1;
        } else {
            $cart['order'][$product->getId()]['quantity'] = 1;
        }
        $cart['order'][$product->getId()]['name'] = $product->getName();

        $cart['total'] += $product->getPrice();

        $this->session->set($playerId, $cart);
    }

    public function clearCart(int $playerId) :void
    {
        $this->session->remove($playerId);
    }

    public function getCart(int $playerId) :array
    {
        return $this->session->get($playerId);
    }

    public function resolveCart(Player $player) :void
    {
        $cart = $this->getCart($player->getId());

        foreach ($cart['order'] as $prodId => $details) {
            /** @var Product $prod */
            $prod = $this->em->getRepository(Product::class)->find($prodId);
            $order = new Orders();
            $order->setPlayer($player);
            $order->setQuantity($details['quantity']);
            $order->setProduct($prod);
            $this->em->persist($order);
        }

        $this->em->flush();

        $this->clearCart($player->getId());
    }
}
