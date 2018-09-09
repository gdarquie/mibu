<?php

namespace App\Component\Handler;

use App\Component\Constant\ModelType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Router;

class PersonnageHandler extends BaseHandler
{

    /**
     * PersonnageHandler constructor.
     * @param EntityManager $em
     * @param Router $router
     */
    public function __construct(EntityManager $em, Router $router)
    {
        parent::__construct($em, $router);
        $this->helper = new HelperHandler();
    }

    public function getPersonnage($personnageId)
    {
        return $this->getEntity($personnageId, ModelType::PERSONNAGE);
    }

    public function getPersonnages()
    {
    }

    /**
     * @param $data
     * @return \App\Component\IO\PersonnageIO|mixed
     */
    public function postPersonnage($data)
    {
        return $this->postEntity($data, 'personnage');
    }

    /**
     * @param $personnageId
     * @param $data
     * @return \App\Component\IO\PersonnageIO|mixed
     */
    public function putPersonnage($personnageId, $data)
    {
        return $this->putEntity($personnageId, $data, 'personnage');
    }

    /**
     * @param $personnageId
     * @return JsonResponse
     */
    public function deletePersonnage($personnageId)
    {
        return $this->deleteEntity($personnageId, 'personnage');
    }

}