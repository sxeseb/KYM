<?php


namespace App\Service;

use App\Entity\Orders;
use App\Entity\Player;
use Doctrine\ORM\EntityManagerInterface;

class PlayerCheckManager
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function totalDrinks(Player $player) :int
    {
        $orders = $this->em->getRepository(Orders::class)->findAllOrdersPlayer($player);

        $total = 0;
        foreach($orders as $order) {
            /** @var Orders $order */
            $total += $order->getQuantity() * $order->getProduct()->getPrice();
        }

        return $total;
    }

    public function totalConsigne(Player $player)
    {
        $consignes = $this->em->getRepository(Orders::class)->findAllConsignesPlayer($player);

        $total = 0;
        foreach($consignes as $consigne) {
            /** @var Orders $order */
            $total += $order->getQuantity() * $order->getProduct()->getPrice();
        }

        return $total;
    }
}
