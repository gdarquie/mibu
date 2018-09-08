<?php

namespace App\Component\Hydrator;

use App\Entity\Modele\AbstractElement;

class ElementHydrator extends ConceptHydrator
{
    public function hydrateElement(AbstractElement $element, $data)
    {
        parent::hydrateConcept($element, $data);
//        ($data['fictionId']) ? $element->setFiction($data['fictionId']) : '';
        ($data['fiction']) ? $element->setFiction($data['fiction']) : '';

        return $element;
    }
}