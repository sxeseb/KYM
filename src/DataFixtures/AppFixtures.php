<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // carte journée
        $products = [
            "0.5" => ['fruit', 'barre choco'],
            "1.0" => ['knack', 'cake', 'tarte', 'soft', 'eau'],
            "1.5" => ['salade', 'croques monsieur (2)', 'bière']
        ];

        foreach ($products as $price => $prods) {
            foreach($prods as $prod) {
                    $conso = new Product();
                    $conso->setName($prod);
                    $conso->setPrice((float)$price);
                    $manager->persist($conso);
            }
        }

        // consigne
        $consigne = new Product();
        $consigne->setPrice(1);
        $consigne->persist();

        $manager->flush();
    }
}
