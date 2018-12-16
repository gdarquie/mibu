<?php

namespace App\Component\Transformer;

use App\Component\Constant\ModelType;
use App\Entity\Modele\AbstractConcept;

class ConceptTransformer
{
    /**
     * @param AbstractConcept $concept
     * @param $io
     * @param ModelType $modelType
     *
     * @return mixed
     */
    public function transformConcept(AbstractConcept $concept, $io, $modelType)
    {
        $io->setId($concept->getId());
        $io->setTitre($concept->getTitre());
        $io->setDescription($concept->getDescription());
        $io->setUuid($concept->getUuid());
        $io->setModelType($modelType);
        $io->setDateCreation($concept->getDateCreation());
        $io->setDateModification($concept->getDateModification());

        return $io;
    }
}
