<?php

namespace App\Component\Hydrator;

use App\Entity\Modele\AbstractConcept;

class ConceptHydrator
{
    public function hydrateConcept(AbstractConcept $concept, $data)
    {
        ($data['titre']) ? $concept->setTitre($data['titre']) : '';
        ($data['description']) ? $concept->setDescription($data['description']) : '';

        return $concept;
    }
}
