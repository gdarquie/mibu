<?php

namespace App\Component\Hydrator;

use App\Component\IO\TexteIO;

class TexteHydrator extends ElementHydrator
{
    public function hydrateTexte($texte)
    {
        $texteIO = new TexteIO();
        $texteIO = $this->hydrateElement($texte, $texteIO);

        if($texte->getItem()) {
            $texteIO->setItemId($texte->getItem()->getId());
        }
        
        $texteIO->setType($texte->getType());

        return $texteIO;
    }

}