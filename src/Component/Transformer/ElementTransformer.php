<?php

namespace App\Component\Transformer;

use App\Entity\Modele\AbstractElement;

class ElementTransformer extends ConceptTransformer
{
    public function transformElement(AbstractElement $element, $elementIO, $modelType)
    {
        $io = $this->transformConcept($element, $elementIO, $modelType);

        ($element->getFiction()) ? $io->setFictionId($element->getFiction()) : $io->setFictionId(null); //faut-il forcer l'ajout d'une fiction pour la création d'un élément?

        return $io;
    }
}