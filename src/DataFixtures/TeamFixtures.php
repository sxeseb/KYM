<?php

namespace App\DataFixtures;

use App\Entity\Team;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class TeamFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $admin = new Team();
        $admin->setTeamName('admin');
        $admin->setEmail('admin@kym.fr');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordEncoder->encodePassword(
            $admin,
            'admin'
        ));

        $manager->persist($admin);

        // teams

        $teams = [
            ['teamName' => 'sesqui' , 'email' => 'sesqui@distus.fr', 'roles' => ['ROLE_TEAM'], 'pass' => 'sesquipassword'],
            ['teamName' => 'staff', 'email' => 'staff@kym.fr', 'roles' => ['ROLE_STAFF'], 'pass' => 'staffpassword'],
            ['teamName' => 'frizup ', 'email' => 'frizup@gmail.com', 'roles' => ['ROLE_TEAM'], 'pass' => 'frizuppassword' ],
        ];

        foreach($teams as $team) {
            $user = new Team();
            $user->setTeamName($team['teamName']);
            $user->setEmail($team['email']);
            $user->setRoles($team['roles']);
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                $team['pass']
            ));
            $manager->persist($user);
        }

        $manager->flush();
    }
}
