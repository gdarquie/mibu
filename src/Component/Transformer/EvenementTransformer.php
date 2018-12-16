<?php

namespace App\Component\Transformer;

use App\Component\Constant\ModelType;
use App\Component\IO\EvenementIO;

class EvenementTransformer extends ElementTransformer
{
    public function convertEntityIntoIO($evenement)
    {
        $evenementIO = new EvenementIO();
        $evenementIO = $this->transformElement($evenement, $evenementIO, ModelType::EVENEMENT);

        $evenementIO->setAnneeDebut($evenement->getAnneeDebut());
        $evenementIO->setAnneeFin($evenement->getAnneeFin());

        return $evenementIO;
    }
}
