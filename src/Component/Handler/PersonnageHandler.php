<?php

namespace App\Component\Handler;

use App\Entity\Item\Personnage;
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
        $personnage->setAnneeNaissance($data['annee_naissance']);
        $personnage->setAnneeMort($data['annee_mort']);
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