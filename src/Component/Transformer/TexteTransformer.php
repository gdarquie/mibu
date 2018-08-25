<?php

namespace App\Component\Transformer;

use App\Component\IO\TexteIO;

class TexteTransformer extends ElementTransformer
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