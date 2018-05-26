<?php

namespace App\Component\Hydrator;

use App\Component\IO\FictionIO;


class FictionHydrator
{
    public function hydrateFiction($em, $fiction)
    {
        $fictionId = $fiction->getId();
        $textes = $em->getRepository('App:Concept\Fiction')->getTextesFiction($fictionId);
        $personnages = $em->getRepository('App:Concept\Fiction')->getPersonnagesFiction($fictionId);
        $evenements = $em->getRepository('App:Concept\Fiction')->getEvenementsFiction($fictionId);

        $fictionIO = new FictionIO();

        $fictionIO->setId($fiction->getId());
        $fictionIO->setTitre($fiction->getTitre());
        $fictionIO->setDescription($fiction->getDescription());
        $fictionIO->setUuid($fiction->getUuid());
        //travailler les dates
        $fictionIO->setDateCreation($fiction->getDateCreation());
        $fictionIO->setDateModification($fiction->getDateModification());

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