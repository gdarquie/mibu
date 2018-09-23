<?php

namespace App\Component\Hydrator;

use App\Entity\Concept\Inscrit;

class InscritHydrator extends ConceptHydrator
{
    public function hydrateInscrit(Inscrit $inscrit, $data)
    {
        $inscrit = parent::hydrateConcept($inscrit, $data);

        $inscrit->setPrenom($data['prenom']);
        $inscrit->setNom($data['nom']);
        $inscrit->setGenre($data['genre']);
//        $inscrit->setDateNaissance($data['dateNaissance']);
        $inscrit->setDateNaissance(null);
        $inscrit->setEmail($data['email']);

        return $inscrit;
    }
}