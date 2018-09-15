<?php

namespace App\Component\Handler;

use App\Entity\Element\Evenement;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Routing\Router;

class EvenementHandler extends BaseHandler
{
    /**
     * EvenementHandler constructor.
     * @param EntityManager $em
     * @param Router $router
     */
    public function __construct(EntityManager $em, Router $router)
    {
        parent::__construct($em, $router);
    }

    public function createEvenement(EntityManager $em, $data)
    {
        $helper = new HelperHandler();
        $helper->checkElement($data);
        $fiction = $helper->checkFiction($em, $data);

        $evenement = new Evenement();
        $evenement->setTitre($data['titre']);
        $evenement->setDescription($data['description']);
        (isset($data['annee_debut'])) ? $evenement->setAnneeDebut($data['annee_debut']) : $evenement->setAnneeDebut(null);
        (isset($data['annee_fin'])) ? $evenement->setAnneeFin($data['annee_fin']) : $evenement->setAnneeFin(null);

        $evenement->setFiction($fiction);

        $em->persist($evenement);
        $em->flush();

        return $evenement;
    }

    public function createEvenements(EntityManager $em, $evenements)
    {
        foreach ($evenements as $data)
        {
            $this->createEvenement($em, $data);
        }

        return true;
    }

}