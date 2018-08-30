<?php

namespace App\Component\Hydrator;

use App\Entity\Element\Texte;

class TexteHydrator extends ElementHydrator
{
    public function hydrateTexte(Texte $texte, $data)
    {
        parent::hydrateElement($texte, $data);
        ($data['fiction']) ? $texte->setFiction($data['fiction']) : '';
        ($data['item']) ? $texte->setItem($data['item']) : '';

        return $texte;
    }
}