<?php

namespace App\Component\Transformer;

use App\Component\Constant\ModelType;
use App\Component\IO\FictionIO;
use Doctrine\ORM\EntityManager;


class FictionTransformer extends ConceptTransformer
{
    public function convertEntityIntoIO($fiction)
    {
//        $textes = $this->em->getRepository('App:Concept\Fiction')->getTextesFiction($fictionId);
//        $personnages = $this->em->getRepository('App:Concept\Fiction')->getPersonnagesFiction($fictionId);
//        $evenements = $this->em->getRepository('App:Concept\Fiction')->getEvenementsFiction($fictionId);

        $fictionIO = new FictionIO();
        $fictionIO = $this->transformConcept($fiction, $fictionIO, ModelType::FICTION);

//        if($textes){
//            $fictionIO->setTextes($textes);
//        }
//
//        if($personnages){
//            $fictionIO->setPersonnages($personnages);
//        }
//
//        if($evenements){
//            $fictionIO->setEvenements($evenements);
//        }

        return $fictionIO;
    }

}