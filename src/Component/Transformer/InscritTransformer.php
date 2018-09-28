<?php

namespace App\Component\Transformer;


use App\Component\Constant\ModelType;
use App\Component\IO\InscritIO;

class InscritTransformer extends ConceptTransformer
{
    public function convertEntityIntoIO($inscrit)
    {
        $inscritIO = new InscritIO();
        $inscritIO = $this->transformConcept($inscrit, $inscritIO, ModelType::INSCRIT);

        $inscritIO->setPseudo($inscrit->getPseudo());
        $inscritIO->setPrenom($inscrit->getPrenom());
        $inscritIO->setNom($inscrit->getNom());
        $inscritIO->setGenre($inscrit->getGenre());
        $inscritIO->setEmail($inscrit->getEmail());
        $inscritIO->setDateNaissance($inscrit->getDateNaissance());
        return $inscritIO;
    }
}