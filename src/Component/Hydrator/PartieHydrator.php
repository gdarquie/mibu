<?php

namespace App\Component\Hydrator;

use App\Entity\Element\Partie;

class PartieHydrator extends ElementHydrator
{
    public function hydratePartie(Partie $partie, $data)
    {
        parent::hydrateElement($partie, $data);
        (isset($data['item'])) ? $partie->setItem($data['item']) : '';
    }
}

