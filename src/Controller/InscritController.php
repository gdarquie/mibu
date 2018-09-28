<?php

namespace App\Controller;

use App\Component\Constant\ModelType;
use App\Component\Handler\InscritHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

class InscritController extends BaseController
{
    /**
     * @Rest\Get("inscrits", name="get_inscrits")
     */
    public function getInscrits(Request $request): Response
    {
        return $this->getAllAction($request, ModelType::INSCRIT);
    }

    /**
     * @Rest\Get("inscrits/{inscritId}", name="get_inscrit")
     */
    public function getInscrit($inscritId)
    {
        return $this->getAction($inscritId, ModelType::INSCRIT);
    }

    /**
     * @Rest\Post("inscrits", name="post_inscrit")
     */
    public function postInscrit(Request $request)
    {
        return $this->postAction($request, ModelType::INSCRIT);
    }

    /**
     * @Rest\Put("inscrits/{inscritId}", name="put_inscrit")
     */
    public function putInscrit(Request $request, $inscritId)
    {
        return $this->putAction($request, $inscritId, ModelType::INSCRIT);
    }
    

    /**
     * @Rest\Delete("/inscrits/{inscritId}",name="delete_inscrit")
     */
    public function deleteInscrit($inscritId)
    {
        return $this->deleteAction($inscritId, ModelType::INSCRIT);
    }

    /**
     * @return InscritHandler
     */
    public function getHandler()
    {
        return new InscritHandler($this->getDoctrine()->getManager(), $this->get('router'));
    }


}