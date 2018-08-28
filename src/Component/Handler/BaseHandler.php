<?php

namespace App\Component\Handler;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Routing\Router;

class BaseHandler
{
    protected $em;
    protected $router;

    /**
     * BaseHandler constructor.
     * @param EntityManager $em
     * @param Router $router
     */
    public function __construct(EntityManager $em, Router $router)
    {
        $this->em = $em;
        $this->router = $router;
    }

    /**
     * @param $route
     * @param array $params
     * @param $targetPage
     * @return string
     */
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

    /**
     * @param $entity
     * @return bool
     */
    public function save($entity)
    {
        $this->em->persist($entity);
        $this->em->flush();

        return true;
    }

}