<?php

namespace App\Component\Transformer;

use App\Component\IO\EvenementIO;

class EvenementTransformer extends ElementTransformer
{
    public function hydrateEvenement($evenement)
    {
        $evenementIO = new EvenementIO();
        $evenementIO = $this->hydrateElement($evenement, $evenementIO);

        $evenementIO->setAnneeDebut($evenement->getAnneeDebut());
        $evenementIO->setAnneeFin($evenement->getAnneeFin());
        
        return $evenementIO;
    }
}