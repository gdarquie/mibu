<?php

namespace App\Component\Hydrator;

use App\Component\IO\TexteIO;


class TexteHydrator
{
    public function createTexte($em, $texte)
    {
        $texteIO = new TexteIO();

        $texteIO->setTitre($texte->getTitre());
        $texteIO->setContenu($texte->getDescription());

        return $texteIO;
    }
}