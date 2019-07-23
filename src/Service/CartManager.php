<?php

namespace App\Service;

use App\Entity\Product;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartManager
{
    private $session;
    private $playerId;

    public function __construct(SessionInterface $session, int $playerId)
    {
        $this->session = $session;
        $this->playerId = $playerId;
    }

    public function initCart() :array
    {
        $playerCart = [];
        $playerCart['total'] = 0;
        $playerCart['order'] = [];

        return $playerCart;
    }

    public function addToCart(Product $product) :void
    {
        $cart = $this->session->get($this->playerId, $this->initCart());

        if (key_exists($product->getId(), $cart['order'])) {
            $cart['order'][$product->getId()]['quantity'] += 1;
        } else {
            $cart['order'][$product->getId()]['quantity'] = 1;
        }
        $cart['order'][$product->getId()]['name'] = $product->getName();

        $cart['total'] += $product->getPrice();

        $this->session->set($this->playerId, $cart);
    }

    public function clearCart() :void
    {
        $this->session->remove($this->playerId);
    }

    public function getCart() :array
    {
        $cart = $this->session->get($this->playerId);

        return $cart;
    }
}
