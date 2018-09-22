<?php

namespace App\Component\Hydrator;

class InscritHydrator extends ConceptHydrator
{
    public function hydrateInscrit($inscrit, $data)
    {
        $inscrit = parent::hydrateConcept($inscrit, $data);

        return $inscrit;
    }
}