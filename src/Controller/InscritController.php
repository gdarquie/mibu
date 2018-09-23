<?php

namespace App\Controller;


use App\Component\Handler\InscritHandler;
use App\Component\IO\InscritIO;
use App\Form\InscritType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

class InscritController extends BaseController
{
    public function getInscrit()
    {
        
    }
    
    /**
     * @Rest\Post("inscrits", name="post_inscrit")
     *
     *
     * @param Request $request
     * @return JsonResponse|Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function postInscrit(Request $request)
    {
        $data = $this->getData($request);
        $inscritIO = new InscritIO();
        $form = $this->createForm(InscritType::class, $inscritIO);
        $form->submit($data);

        if($form->isSubmitted()) {  //remplacer par isValidate
            $inscritIO = $this->getHandler()->postInscrit($data);
            $url = $this->createRouteGetFiction(json_decode($inscritIO)->id);
            $response = $this->createResponse($inscritIO, $url);

            return $response;
        }

        return new JsonResponse("Echec de l'insertion", 500);
    }

    /**
     * @return InscritHandler
     */
    public function getHandler()
    {
        //get service
        $inscritHandler = new InscritHandler($this->getDoctrine()->getManager(), $this->get('router'));
        return $inscritHandler;
    }

    /**
     * @param $io
     * @param null $url
     * @return Response
     */
    public function createResponse($io, $url = null)
    {
        $response = new Response($io);
        $response->headers->set('Content-Type', 'application/json');

        if (isset($url)) {
            $response->headers->set('Location', $url);
        }

        return $response;
    }

    /**
     * @param $id
     * @return string
     */
    public function createRouteGetFiction($id)
    {
        $url = $this->generateUrl(
            'get_inscrit', array(
            'id' => $id
        ));

        return $url;
    }
}