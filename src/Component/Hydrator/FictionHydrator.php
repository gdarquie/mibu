<?php

namespace App\Component\Hydrator;

use App\Component\IO\FictionIO;
use Doctrine\ORM\EntityManager;


class FictionHydrator
{
    //récupérer l'em directement ici

    /**
     * @var EntityManager
     */
    protected $em;


    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    public function hydrateFiction($fiction)
    {
        $fictionId = $fiction->getId();
        $textes = $this->em->getRepository('App:Concept\Fiction')->getTextesFiction($fictionId);
        $personnages = $this->em->getRepository('App:Concept\Fiction')->getPersonnagesFiction($fictionId);
        $evenements = $this->em->getRepository('App:Concept\Fiction')->getEvenementsFiction($fictionId);

        $fictionIO = new FictionIO();

        $fictionIO->setId($fiction->getId());
        $fictionIO->setTitre($fiction->getTitre());
        $fictionIO->setDescription($fiction->getDescription());
        $fictionIO->setUuid($fiction->getUuid());
        //todo : retravailler les dates - renvoyer dans un format compréhensible
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