<?php

namespace App\Controller;


use App\Component\Serializer\CustomSerializer;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;

class BaseController extends FOSRestController
{
    public function createApiResponse($data, $statusCode = 200, $url = null)
    {
        $response = new Response($this->getSerializer()->serialize($data));
        $response->headers->set('Content-Type', 'application/json');

        if (isset($url)) {
            $response->headers->set('Location', $url);
        }

        return $response;
    }

    public function getSerializer()
    {
        return new CustomSerializer();
    }

    public function createUrl($route, $routeParams, $targetPage)
    {
        return $this->generateUrl($route, array_merge(
            $routeParams,
            array('page' => $targetPage)
        ));
    }
}
