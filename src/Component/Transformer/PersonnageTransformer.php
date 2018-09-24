<?php

namespace App\Component\Transformer;

use App\Component\Constant\ModelType;
use App\Component\IO\PersonnageIO;

class PersonnageTransformer extends ElementTransformer
{
    public function convertEntityIntoIO($personnage)
    {
        $personnageIO = new PersonnageIO();
        $personnageIO = $this->transformElement($personnage, $personnageIO, ModelType::PERSONNAGE);

        $personnageIO->setNom($personnage->getNom());
        $personnageIO->setPrenom($personnageIO->getPrenom());
        $personnageIO->setAnneeNaissance($personnage->getAnneeNaissance());
        $personnageIO->setAnneeMort($personnage->getAnneeMort());

        return $personnageIO;
    }

}

