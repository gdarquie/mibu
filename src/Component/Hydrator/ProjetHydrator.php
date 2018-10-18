<?php

namespace App\Component\Hydrator;

class ProjetHydrator extends ElementHydrator
{
    public function hydrateProjet($projet, $data)
    {
        $projet = parent::hydrateElement($projet, $data);

        return $projet;
    }
}