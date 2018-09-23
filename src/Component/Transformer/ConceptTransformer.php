<?php

namespace App\Component\Transformer;

use App\Entity\Modele\AbstractConcept;

class ConceptTransformer
{
    public function transformConcept(AbstractConcept $concept, $io)
    {
        $io->setId($concept->getId());
        $io->setTitre($concept->getTitre());
        $io->setDescription($concept->getDescription());
        $io->setUuid($concept->getUuid());
        $io->setDateCreation($concept->getDateCreation());
        $io->setDateModification($concept->getDateModification());

        return $io;
    }
}