<?php

namespace App\Component\Handler;

use App\Entity\Element\Partie;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Routing\Router;

class PartieHandler extends BaseHandler
{
    /**
     * PartieHandler constructor.
     * @param EntityManager $em
     * @param Router $router
     */
    public function __construct(EntityManager $em, Router $router)
    {
        parent::__construct($em, $router);
    }

    public function createPartie(EntityManager $em, $data)
    {
        //remplacer par un post sans form?
        $helper = new HelperHandler($data);
        $helper->checkElement($data);
        $fiction = $helper->checkFiction($em, $data);

        $titre = $data['titre'];
        $description = $data['description'];

        $partie = new Partie($titre, $description, $fiction);
        $em->persist($partie);
        $em->flush();

        return $partie;
    }

    public function createParties(EntityManager $em, $parties)
    {
        foreach ($parties as $data)
        {
            $this->createPartie($em, $data);
        }

        return true;
    }

}