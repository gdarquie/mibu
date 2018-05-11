<?php

namespace App\Component\Handler;

use App\Entity\Element\Partie;
use Doctrine\ORM\EntityManager;

class PartieHandler
{
    public function createPartie(EntityManager $em, $data, $fiction)
    {
        if(!isset($data['titre']) && !isset($data['description'])){
            throw $this->createNotFoundException(sprintf(
                'Il manque un champ titre ou description'
            ));
        }

        $titre = $data['titre'];
        $description = $data['description'];

        $partie = new Partie($titre, $description, $fiction);
        $em->persist($partie);
        $em->flush();

        return $partie;
    }

    public function createPersonnages(EntityManager $em, $parties, $fiction)
    {
        foreach ($parties as $data)
        {
            $this->createPartie($em, $data, $fiction);
        }

        return true;
    }

}