<?php

namespace App\Component\Hydrator;

use App\Component\IO\TexteIO;


class TexteHydrator
{

    public function getTexte($em, $id)
    {
        $texte = $em->getRepository('App:Concept\Texte')->getTexte($id);
        $texteIO = $this->createTexte($em, $texte);
        $texteIO = $this->serialize($texteIO);
        return $texteIO;

    }

    public function createTexte($em, $texte)
    {
        $texteIO = new TexteIO();

        $texteIO->setTitre($texte->getTitre());
        $texteIO->setContenu($texte->getDescription());

        //date de création et dernière update?


        return $texteIO;
    }
}