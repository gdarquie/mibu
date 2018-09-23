<?php

namespace App\Component\Handler;

use App\Component\Constant\ModelType;
use App\Entity\Concept\Inscrit;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Routing\Router;

class InscritHandler extends BaseHandler
{
    public function __construct(EntityManager $em, Router $router)
    {
        parent::__construct($em, $router);
    }

    public function postInscrit($data)
    {
        $inscrit = new Inscrit();
        $inscrit = $this->getEntityHydrator(ModelType::INSCRIT)->hydrateInscrit($inscrit, $data);

        //add a check for testing if valid? (add a form)
        $inscritIO = $this->saveInscrit($inscrit);

        return $inscritIO;
    }

    public function saveInscrit($inscrit)
    {
        //save
        $this->save($inscrit);

        //transform into IO
        $inscritIO = $this->getEntityTransformer(ModelType::INSCRIT)->convertEntityIntoIO($inscrit);

        return $inscritIO;
    }

}