<?php

namespace App\Component\Hydrator;

use App\Component\IO\PartieIO;

class PartieHydrator
{
    public function hydratePartie($partie)
    {
        $partieIO = new PartieIO();

        $partieIO->setId($partie->getId());
        $partieIO->setTitre($partie->getTitre());
        $partieIO->setContenu($partie->getDescription());

        return $partieIO;
    }
}