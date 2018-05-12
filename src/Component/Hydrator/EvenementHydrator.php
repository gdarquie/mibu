<?php

namespace App\Component\Hydrator;

use App\Component\IO\EvenementIO;

class EvenementHydrator extends ElementHydrator
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