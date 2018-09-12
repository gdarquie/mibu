<?php

namespace App\Component\Hydrator;

use App\Entity\Element\Evenement;

class EvenementHydrator
{
    public function hydrateEvenement(Evenement $evenement, $data)
    {
        parent::hydrateElement($evenement, $data);
        (isset($data['item'])) ? $evenement->setItem($data['item']) : '';

        return $evenement;
    }
}