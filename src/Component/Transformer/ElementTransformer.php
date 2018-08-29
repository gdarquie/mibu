<?php

namespace App\Component\Transformer;

use App\Entity\Modele\AbstractElement;

class ElementTransformer
{
    //todo : ajouter un ConceptTransformer? | penser composition plutôt que hiérarchie?
    public function transformElement(AbstractElement $element, $io)
    {
//        dump($element);die;
        $io->setId($element->getId());
        $io->setTitre($element->getTitre());
        $io->setDescription($element->getDescription());
        ($element->getFiction()) ? $io->setFictionId($element->getFiction()) : $io->setFictionId(null); //faut-il forcer l'ajout d'une fiction pour la création d'un élément?
        $io->setUuid($element->getUuid());
        $io->setDateCreation($element->getDateCreation());
        $io->setDateModification($element->getDateModification());

        return $io;
    }
}