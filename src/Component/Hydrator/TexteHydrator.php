<?php

namespace App\Component\Hydrator;

use App\Entity\Element\Texte;

class TexteHydrator extends ElementHydrator
{
    public function hydrateTexte(Texte $texte, $data)
    {
        parent::hydrateElement($texte, $data);
        ($data['fictionId']) ? $texte->setFiction($data['fictionId']) : '';

        return $texte;
    }
}