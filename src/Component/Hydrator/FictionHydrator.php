<?php

namespace App\Component\Hydrator;

class FictionHydrator extends ConceptHydrator
{
    public function hydrateFiction($fiction, $data)
    {
        $fiction = parent::hydrateConcept($fiction, $data);

        return $fiction;
    }
}
