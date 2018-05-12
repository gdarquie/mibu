<?php

namespace App\Component\Hydrator;

use App\Component\IO\PersonnageIO;

class PersonnageHydrator extends ElementHydrator
{
    public function hydratePersonnage($personnage)
    {
        $personnageIO = new PersonnageIO();
        $personnageIO = $this->hydrateElement($personnage, $personnageIO);

        $personnageIO->setNom($personnage->getNom());
        $personnageIO->setPrenom($personnageIO->getPrenom());
        $personnageIO->setAnneeNaissance($personnage->getAnneeNaissance());
        $personnageIO->setAnneeMort($personnage->getAnneeMort());

        return $personnageIO;
    }
}