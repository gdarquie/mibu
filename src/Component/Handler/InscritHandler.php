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
        dump($inscritIO);die;

        //todo = refacto en une seule fonction
        if(isset($data['textes'])){

            if($data['textes'] !== null){
                for ($i = 0; $i < count($data['textes']); $i++) {
                    $data['textes'][0]['fictionId'] =  $fiction->getId();
                }

                $texteHandler = new TexteHandler($this->em, $this->router);
                $texteHandler->createTextes($this->em, $data['textes']);

            }

        dump('hello');die;
        return true;
        }
    }

    public function saveInscrit($inscrit)
    {
        //save
        $this->save($inscrit);

        //transform into IO
        $inscritIO = $this->getEntityTransformer(ModelType::INSCRIT)->convertEntityIntoIO($inscrit);
dump($inscritIO);die;
        return $inscritIO;
    }

}