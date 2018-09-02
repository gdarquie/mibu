<?php

namespace App\Component\Hydrator;

use App\Entity\Element\Texte;

class TexteHydrator extends ElementHydrator
{
    public function hydrateTexte(Texte $texte, $data)
    {
        parent::hydrateElement($texte, $data);

        (isset($data['fiction'])) ? $texte->setFiction($data['fiction']) : '';
        (isset($data['item'])) ? $texte->setItem($data['item']) : '';

        return $texte;
    }
}