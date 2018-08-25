<?php

namespace App\Component\Handler;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Routing\Router;

class BaseHandler
{
    protected $em;
    protected $router;

    public function __construct(EntityManager $em, Router $router)
    {
        $this->em = $em;
        $this->router = $router;
    }

    public function generateUrl($route, array $params, $targetPage)
    {
        return $this->router->generate(
            $route,
            array_merge(
                $params,
                array('page' => $targetPage)
            )
        );
    }
}