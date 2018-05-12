<?php

namespace App\Component\Hydrator;

use App\Component\IO\PartieIO;

class PartieHydrator extends ElementHydrator
{
    public function hydratePartie($partie)
    {
        $partieIO = new PartieIO();
        $partieIO = $this->hydrateElement($partie, $partieIO);
        //textes

        return $partieIO;
    }

}