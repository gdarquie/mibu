<?php

namespace App\Component\Hydrator;

use App\Entity\Element\Lieu;

class LieuHydrator extends ElementHydrator
{
    public function hydrateLieu(Lieu $lieu, $data)
    {
        parent::hydrateElement($lieu, $data);
        (isset($data['item'])) ? $lieu->setItem($data['item']) : '';
        (isset($data['lat'])) ? $lieu->setLat($data['lat']) : '';
        (isset($data['long'])) ? $lieu->setLong($data['long']) : '';

        return $lieu;
    }
}
