<?php

namespace App\Component\Handler;

use App\Entity\Element\Texte;
use Doctrine\ORM\EntityManager;

class TexteHandler
{
    public function createTexte(EntityManager $em, $data, $fiction)
    {
        $titre = $data['titre'];
        $description = $data['description'];
        $type = $data['type'];

        $texte = new Texte($titre, $description, $type, $fiction);

        $em->persist($texte);
        $em->flush();

        return $texte;
    }


    public function createTextes(EntityManager $em, $textes, $fiction)
    {
        foreach ($textes as $data)
        {
            $this->createTexte($em, $data, $fiction);
        }

        return true;
    }
}