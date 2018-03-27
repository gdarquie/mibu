<?php

namespace App\Component\Handler;

use App\Component\IO\TexteIO;
use App\Entity\Element\Texte;
use Doctrine\ORM\EntityManager;

class TexteHandler
{
    public function createTexte(EntityManager $em, TexteIO $texteIO)
    {
        $texte = new Texte();
        $texte->setTitre($texteIO->getTitre());
        $texte->setDescription($texteIO->getDescription());
        $em->persist($texte);
        $em->flush();

        $id = $texte->getId();
        return $id;

    }
}