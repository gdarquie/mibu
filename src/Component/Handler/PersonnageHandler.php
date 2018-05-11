<?php

namespace App\Component\Handler;

use App\Entity\Element\Personnage;
use Doctrine\ORM\EntityManager;

class PersonnageHandler
{
    public function createPersonnage(EntityManager $em, $data, $fiction)
    {
        if(!isset($data['titre']) && !isset($data['description'])){
            throw $this->createNotFoundException(sprintf(
                'Il manque un champ surnom ou de description'
            ));
        }

        $titre = $data['titre'];
        $description = $data['description'];

        $personnage = new Personnage($titre, $description);
        (isset($data['nom'])) ? $personnage->setNom($data['nom']) : $personnage->setNom(null);
        (isset($data['prenom'])) ? $personnage->setPrenom($data['prenom']) : $personnage->setPrenom(null);
        (isset($data['annee_naissance'])) ? $personnage->setAnneeNaissance($data['annee_naissance']) : $personnage->setAnneeNaissance(null);
        (isset($data['annee_mort'])) ? $personnage->setAnneeMort($data['annee_mort']) : $personnage->setAnneeMort(null);
        (isset($data['genre'])) ? $personnage->setGenre($data['genre']) : $personnage->setGenre(null);

        $personnage->setFiction($fiction);

        $em->persist($personnage);
        $em->flush();

        return $personnage;
    }

    public function createPersonnages(EntityManager $em, $personnages, $fiction)
    {
        foreach ($personnages as $data)
        {
            $this->createPersonnage($em, $data, $fiction);
        }

        return true;
    }

}