<?php

namespace App\Service;

use App\Entity\Product;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartManager
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function initCart() :array
    {
        $playerCart = [];
        $playerCart['total'] = 0;
        $playerCart['order'] = [];

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
        $cart = $this->session->get($playerId);

        return $cart;
    }
}
