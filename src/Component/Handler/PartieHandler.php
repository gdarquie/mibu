<?php

namespace App\Component\Handler;

use App\Entity\Element\Partie;
use Doctrine\ORM\EntityManager;

class PartieHandler
{
    public function createPartie(EntityManager $em, $data)
    {
        $helper = new HelperHandler($data);
        $helper->checkElement($data);
        $fiction = $helper->checkFiction($em, $data);

        $titre = $data['titre'];
        $description = $data['description'];

        $partie = new Partie($titre, $description, $fiction);
        $em->persist($partie);
        $em->flush();

        return $partie;
    }

    public function createParties(EntityManager $em, $parties)
    {
        foreach ($parties as $data)
        {
            $this->createPartie($em, $data);
        }

        return true;
    }

}