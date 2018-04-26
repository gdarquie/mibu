<?php

namespace App\Component\Hydrator;

use App\Component\IO\EvenementIO;
use App\Entity\Item\Evenement;

class EvenementHydrator
{
    public function hydrateEvenement($em, $evenement)
    {
        $evenementIO = new EvenementIO();

        $evenementIO->setId($evenement->getId());
        $evenementIO->setTitre($evenement->getTitre());
        $evenementIO->setDescription($evenement->getDescription());
        $evenementIO->setAnneeDebut($evenement->getAnneeDebut());
        $evenementIO->setAnneeFin($evenement->getAnneeFin());
        
        return $evenementIO;
    }
}