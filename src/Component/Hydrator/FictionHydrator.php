<?php

namespace App\Component\Hydrator;

use App\Component\IO\FictionIO;


class FictionHydrator
{

    public function getFiction($em, $id)
    {
        $fiction = $em->getRepository('App:Concept\Fiction')->getFiction($id);
        $fictionIO = $this->createFiction($em, $fiction);
        $fictionIO = $this->serialize($fictionIO);
        return $fictionIO;

    }

    public function createFiction($em, $fiction)
    {
        $fictionId = $fiction->getId();
        $textes = $em->getRepository('App:Concept\Fiction')->getTextesFiction($fictionId);
        $personnages = $em->getRepository('App:Concept\Fiction')->getPersonnagesFiction($fictionId);
        $evenements = $em->getRepository('App:Concept\Fiction')->getEvenementsFiction($fictionId);

        $fictionIO = new FictionIO();

        $fictionIO->setId($fiction->getId());
        $fictionIO->setTitre($fiction->getTitre());
        $fictionIO->setResume($fiction->getDescription());

        //date de création et dernière update?

        if($textes){
            $fictionIO->setTextes($textes);
        }

        if($personnages){
            $fictionIO->setPersonnages($personnages);
        }

        if($evenements){
            $fictionIO->setEvenements($evenements);
        }

        return $fictionIO;
    }
}