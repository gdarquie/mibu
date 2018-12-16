<?php

namespace App\Component\Hydrator;

use App\Entity\Element\Personnage;

class PersonnageHydrator extends ElementHydrator
{
    public function hydratePersonnage(Personnage $personnage, $data)
    {
        parent::hydrateElement($personnage, $data);
        (isset($data['anneeNaissance'])) ? $personnage->setAnneeNaissance($data['anneeNaissance']) : '';
        (isset($data['anneeMort'])) ? $personnage->setAnneeMort($data['anneeMort']) : '';
        (isset($data['nom'])) ? $personnage->setNom($data['nom']) : '';
        (isset($data['prenom'])) ? $personnage->setPrenom($data['prenom']) : '';
        (isset($data['genre'])) ? $personnage->setGenre($data['genre']) : '';
        (isset($data['auto'])) ? $personnage->setAuto($data['auto']) : '';

        return $personnage;
    }
}
