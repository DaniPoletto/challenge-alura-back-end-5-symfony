<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('teste@teste.com.br')
            ->setPassword('$2y$13$TNEXZ3/d.t0Jv56bUDAYWuMa5kgPFPLEsOvcd/kpdy0n5CQFJp7Hi');
        
        $manager->persist($user);
        $manager->flush();
    }
}
