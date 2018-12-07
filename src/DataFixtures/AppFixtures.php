<?php

namespace App\DataFixtures;

use App\Entity\Concept\Fiction;
use App\Entity\Concept\Inscrit;
use App\Entity\Element\Lieu;
use App\Entity\Element\Personnage;
use App\Entity\Element\Texte;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        //create inscrit
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

        //create fiction
        $fiction = new Fiction();
        $fiction->setTitre('fiction');
        $fiction->setDescription('Description de la fiction');
        $manager->persist($fiction);

        //create textes
        for ($i = 0; $i < 20; $i++) {
            $texte = new Texte('texte'.$i, 'description du texte '.$i, 'fragment');
            $texte->setFiction($fiction);
            $manager->persist($texte);
        }

        //create personnages
        for ($i = 0; $i < 20; $i++) {

            $personnage = new Personnage('personnage'.$i, 'Description du personnage'.$i);
            $personnage->setPrenom('Okita');
            $personnage->setNom('Soji');
            $personnage->setGenre('H');
            $personnage->setFiction($fiction);
            $personnage->setAnneeNaissance(0);
            $personnage->setAnneeMort(100);
            $manager->persist($personnage);
        }

        //create lieux
        for ($i = 0; $i < 20; $i++) {

            $lieu = new Lieu('lieu'.$i, 'Description du lieu'.$i);
            $lieu->setTitre('Saeda');
            $lieu->setDescription('Le pays où est né Atalaire');
            $lieu->setFiction($fiction);
            $manager->persist($personnage);
        }

        $manager->flush();
    }
}