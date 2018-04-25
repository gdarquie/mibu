<?php

namespace App\Component\Hydrator;

use App\Component\IO\PersonnageIO;
use App\Entity\Item\Personnage;


class PersonnageHydrator
{

    public function getEvenement($em, $id)
    {
        $evenement = $em->getRepository(Personnage::class)->getTexte($id);
        $evenementIO = $this->createPersonnage($em, $evenement);
        $evenementIO = $this->serialize($evenementIO);
        return $evenementIO;

    }

    public function createEvenement($em, $evenement)
    {
        $evenementIO = new PersonnageIO();

        $evenementIO->setTitre($evenement->getTitre());
        $evenementIO->setNom($evenement->getNom());
        $evenementIO->setPrenom($evenementIO->getPrenom());
        $evenementIO->setDescription($evenement->getDescription());
        $evenementIO->setAnneeNaissance($evenement->getAnneeNaissance());
        $evenementIO->setAnneeMort($evenement->getAnneeMort());
        
        return $evenementIO;
    }
}