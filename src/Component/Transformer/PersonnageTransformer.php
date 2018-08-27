<?php

namespace App\Component\Transformer;

use App\Component\IO\PersonnageIO;

class PersonnageTransformer extends ElementTransformer
{
    public function hydratePersonnage($personnage)
    {
        $personnageIO = new PersonnageIO();
        $personnageIO = $this->transformElement($personnage, $personnageIO);

        $personnageIO->setNom($personnage->getNom());
        $personnageIO->setPrenom($personnageIO->getPrenom());
        $personnageIO->setAnneeNaissance($personnage->getAnneeNaissance());
        $personnageIO->setAnneeMort($personnage->getAnneeMort());

        return $personnageIO;
    }
}