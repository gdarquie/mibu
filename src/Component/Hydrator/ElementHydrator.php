<?php

namespace App\Component\Hydrator;

use App\Component\IO\ElementIO;

class ElementHydrator
{
    public function hydrate($element)
    {
        $elmentIO = new ElementIO();

        $elmentIO->setId($element->getId());
        $elmentIO->setTitre($element->getTitre());
        $elmentIO->setDescription($element->getDescription());

        return $elmentIO;
    }
}