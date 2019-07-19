<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BarController extends AbstractController
{
    /**
     * @Route("/bar", name="bar_index")
     */
    public function index()
    {
        return $this->render('bar/index.html.twig', [
            'controller_name' => 'BarController',
        ]);
    }
}
