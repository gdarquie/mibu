<?php

namespace App\Component\Hydrator;

use App\Component\IO\PersonnageIO;
use App\Entity\Item\Personnage;


class PersonnageHydrator
{
    public function hydratePersonnage($em, $personnage)
    {
        $personnageIO = new PersonnageIO();

        $personnageIO->setId($personnage->getId());
        $personnageIO->setSurnom($personnage->getTitre());
        $personnageIO->setNom($personnage->getNom());
        $personnageIO->setPrenom($personnageIO->getPrenom());
        $personnageIO->setDescription($personnage->getDescription());
        $personnageIO->setAnneeNaissance($personnage->getAnneeNaissance());
        $personnageIO->setAnneeMort($personnage->getAnneeMort());
        
        return $personnageIO;
    }
}