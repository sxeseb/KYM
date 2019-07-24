<?php


namespace App\Contract;

use App\Entity\Player;
use App\Entity\Product;

interface CartManagerInterface
{
    /**
     * Initialize un panier type avec la structure appropriée
     *  $panier = [
     *      'total' => 0,
     *      'order' => []
     *  ]
     */
    public function initCart() :array;

    /**
     * Ajout d'un produit au panier. Information stockée dans la session
     */
    public function addToCart(Product $product, int $playerId) :void;

    /**
     * Clear d'un panier dans la session, identifié par l'id du Player
     */
    public function clearCart(int $playerId) :void;

    /**
     * Récupération du panier sous forme d'array
     */
    public function getCart(int $playerId) :array;

    /**
     * Enregistrement du contenu du panier en base dans un objet Orders puis nettoyage du panier
     */
    public function resolveCart(Player $player) :void;
}
