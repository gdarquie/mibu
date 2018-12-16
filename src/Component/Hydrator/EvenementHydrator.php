<?php

namespace App\Component\Hydrator;

use App\Entity\Element\Evenement;

class EvenementHydrator extends ElementHydrator
{
    public function hydrateEvenement(Evenement $evenement, $data)
    {
        parent::hydrateElement($evenement, $data);
        (isset($data['item'])) ? $evenement->setItem($data['item']) : '';
        (isset($data['anneeDebut'])) ? $evenement->setAnneeDebut($data['anneeDebut']) : '';
        (isset($data['anneeFin'])) ? $evenement->setAnneeFin($data['anneeFin']) : '';

        return $evenement;
    }
}
