<?php

namespace App\Component\Handler;

use App\Entity\Item\Personnage;
use Doctrine\ORM\EntityManager;

class PersonnageHandler
{
    public function createPersonnage(EntityManager $em, $data, $fiction)
    {
        $nom = $data['nom'];
        $description = $data['description'];

        $personnage = new Personnage($nom, $description);
        $personnage->setAnneeNaissance($data['date_naissance']);
        $personnage->setAnneeMort($data['date_mort']);
        $personnage->setFiction($fiction);

        $em->persist($personnage);
        $em->flush();
    }

}