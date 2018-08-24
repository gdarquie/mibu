<?php

namespace App\Component\Handler;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class BaseHandler
{
    private $router;

    public function __construct(UrlGeneratorInterface $router, EntityManager $em)
    {
        $this->em = $em;
    }

    //todo = utiliser la fonction quand injection de dépendance ok
    public function generateUrl($route, $params, $targetPage)
    {
        dump($this);die;
        return $this->router->generate(
            $route,
            array_merge(
                $params,
                array('page' => $targetPage)
            )
        );
    }
}