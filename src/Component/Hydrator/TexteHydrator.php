<?php

namespace App\Component\Hydrator;

use App\Component\IO\TexteIO;

class TexteHydrator
{
    public function hydrateTexte($texte)
    {
        $texteIO = new TexteIO();

        $texteIO->setId($texte->getId());
        $texteIO->setTitre($texte->getTitre());
        $texteIO->setDescription($texte->getDescription());

        return $texteIO;
    }
}