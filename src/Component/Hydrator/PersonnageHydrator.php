<?php

namespace App\Component\Hydrator;

use App\Component\IO\PersonnageIO;
use App\Entity\Item\Personnage;


class PersonnageHydrator
{

    public function getTexte($em, $id)
    {
        $personnage = $em->getRepository(Personnage::class)->getTexte($id);
        $personnageIO = $this->createPersonnage($em, $personnage);
        $personnageIO = $this->serialize($personnageIO);
        return $personnageIO;

    }

    public function createPersonnage($em, $personnage)
    {
        $personnageIO = new PersonnageIO();

        $personnageIO->setSurnom($personnage->getTitre());
        $personnageIO->setNom($personnage->getNom());
        $personnageIO->setPrenom($personnageIO->getPrenom());
        $personnageIO->setDescription($personnage->getDescription());
        $personnageIO->setAnneeNaissance($personnage->getAnneeNaissance());
        $personnageIO->setAnneeMort($personnage->getAnneeMort());
        
        return $personnageIO;
    }
}