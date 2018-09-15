<?php

namespace App\Component\Handler;

use App\Component\Constant\ModelType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Routing\Router;

class TexteHandler extends BaseHandler
{
    /**
     * TexteHandler constructor.
     * @param EntityManager $em
     * @param Router $router
     */
    public function __construct(EntityManager $em, Router $router)
    {
        parent::__construct($em, $router);
    }

    /**
     * @param $textes
     * @return bool
     */
    public function createTextes($textes)
    {
        foreach ($textes as $data)
        {
            $this->postEntity($data, modelType::TEXTE);
        }

        return true;
    }
}