<?php

namespace App\Component\Handler;

use App\Component\Constant\ModelType;
use App\Component\Hydrator\PartieHydrator;
use App\Component\Transformer\PartieTransformer;
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

    /**
     * @param $id
     * @return mixed
     */
    public function getPartie($id)
    {
        return $this->getEntity($id, ModelType::PARTIE);
    }

    /**
     * @return \App\Component\IO\PersonnageIO|mixed
     */
    public function postPartie($data)
    {
        return $this->postEntity($data, ModelType::PARTIE);
    }

    /**
     * @param $partieId
     * @param $data
     * @return \App\Component\IO\PersonnageIO|mixed
     */
    public function putPartie($partieId, $data)
    {
        return $this->putEntity($partieId, $data, ModelType::PARTIE);
    }

    /**
     * @param $partieId
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function deletePartie($partieId)
    {
        return $this->deleteEntity($partieId, ModelType::PARTIE);
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

    /**
     * @return PartieHydrator
     */
    public function getHydrator(): PartieHydrator
    {
        return new PartieHydrator();
    }

    /**
     * @return PartieTransformer
     */
    public function getTransformer() : PartieTransformer
    {
        return new PartieTransformer();
    }

}