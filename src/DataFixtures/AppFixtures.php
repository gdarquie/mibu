<?php

namespace App\DataFixtures;

use App\Entity\Concept\Fiction;
use App\Entity\Concept\Inscrit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $inscrit = new Inscrit();
        $inscrit->setPseudo('user');
        $inscrit->setNom('Inconnu');
        $inscrit->setPrenom('Inconnu');
        $inscrit->setEmail('user@gmail.com');
        $inscrit->setTitre('inscrit');
        $inscrit->setDescription('Description inscrit');
        $inscrit->setPassword(password_hash('password', PASSWORD_BCRYPT));
        $inscrit->setTitre('Utilisateur');
        $manager->persist($inscrit);

        for ($i = 0; $i < 20; $i++) {

            $fiction = new Fiction();
            $fiction->setTitre('fiction '.$i);
            $fiction->setDescription('Description de la fiction '.$i);
            $manager->persist($fiction);
        }

        $manager->flush();
    }
}