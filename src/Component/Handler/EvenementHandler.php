<?php

namespace App\Component\Handler;

use App\Entity\Element\Evenement;
use Doctrine\ORM\EntityManager;

class EvenementHandler
{
    public function createEvenement(EntityManager $em, $data)
    {
        $helper = new HelperHandler($data);
        $helper->checkElement($data);
        $fiction = $helper->checkFiction($em, $data);

        $evenement = new Evenement();
        $evenement->setTitre($data['titre']);
        $evenement->setDescription($data['description']);
        (isset($data['annee_debut'])) ? $evenement->setAnneeDebut($data['annee_debut']) : $evenement->setAnneeDebut(null);
        (isset($data['annee_fin'])) ? $evenement->setAnneeFin($data['annee_fin']) : $evenement->setAnneeFin(null);
        $evenement->setFiction($fiction);



        $em->persist($evenement);
        $em->flush();

        return $evenement;
    }

    public function createEvenements(EntityManager $em, $evenements)
    {
        foreach ($evenements as $data)
        {
            $this->createEvenement($em, $data, $fiction);
        }

        return true;
    }

}