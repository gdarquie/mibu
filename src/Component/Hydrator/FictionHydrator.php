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
        $textesFiction = $em->getRepository('App:Concept\Fiction')->getTextesFiction($fiction->getId());
        $fictionIO = new FictionIO();

        $fictionIO->setTitre($fiction->getTitre());
        $fictionIO->setResume($fiction->getDescription());

        //date de création et dernière update?

        $promesse = 'A chercher parmi les textes';
        $fictionIO->setPromesse($promesse);
        if($textesFiction){
            $fictionIO->setTextes($textesFiction);
        }

        return $fictionIO;
    }
}