<?php

namespace App\Controller;


use App\Component\Serializer\CustomSerializer;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BaseController extends FOSRestController
{

    /**
     * @param $request
     * @return mixed
     */
    public function getData(Request $request)
    {
        return json_decode($request->getContent(), true);
    }

    /**
     * @param $data
     * @param int $statusCode
     * @param null $url
     * @return Response
     */
    public function createApiResponse($data, $statusCode = 200, $url = null)
    {
        $response = new Response($this->getSerializer()->serialize($data));
        $response->headers->set('Content-Type', 'application/json');
        $response->setStatusCode($statusCode);

        if (isset($url)) {
            $response->headers->set('Location', $url);
        }

        return $response;
    }

    /**
     * @return CustomSerializer
     */
    public function getSerializer()
    {
        return new CustomSerializer();
    }


//    public function createUrl($route, $routeParams, $targetPage)
//    {
//        return $this->generateUrl($route, array_merge(
//            $routeParams,
//            array('page' => $targetPage)
//        ));
//    }
}
