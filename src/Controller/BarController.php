<?php

namespace App\Controller;

use App\Entity\Player;
use App\Entity\Team;
use App\Form\NewPlayerType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BarController extends AbstractController
{
    /**
     * @Route("/bar/{teamName}", name="bar")
     */
    public function index(Request $request, ObjectManager $em, string $teamName = null)
    {
        $player = new Player();
        $newplayerForm = $this->createForm(NewPlayerType::class, $player);
        $teams = $em->getRepository(Team::class)->findAll();

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
        }

        return $this->render('bar/index.html.twig', [
            'form' => $newplayerForm->createView(), 'teams' => $teams, 'selectedTeam' => $team
        ]);
    }
}
