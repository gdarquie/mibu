<?php

namespace App\Component\Hydrator;

use App\Component\IO\TexteIO;

class TexteHydrator extends ElementHydrator
{
    public function hydrateTexte($texte)
    {
        $texteIO = new TexteIO();
        $texteIO = $this->hydrateElement($texte, $texteIO);

        $texteIO->setType($texte->getType());

        return $texteIO;
    }

}