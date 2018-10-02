<?php

namespace App\Controller;

use App\Component\Constant\ModelType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

class InscritController extends BaseController
{
    /**
     * @var string
     */
    public $modelType = ModelType::INSCRIT;

    /**
     * @Rest\Get("inscrits", name="get_inscrits")
     */
    public function getInscrits(Request $request): Response
    {
        return $this->getAllAction($request, $this->modelType);
    }

    /**
     * @Rest\Get("inscrits/{inscritId}", name="get_inscrit")
     */
    public function getInscrit($inscritId)
    {
        return $this->getAction($inscritId,  $this->modelType);
    }

    /**
     * @Rest\Post("inscrits", name="post_inscrit")
     */
    public function postInscrit(Request $request)
    {
        return $this->postAction($request,  $this->modelType);
    }

    /**
     * @Rest\Put("inscrits/{inscritId}", name="put_inscrit")
     */
    public function putInscrit(Request $request, $inscritId)
    {
        return $this->putAction($request, $inscritId,  $this->modelType);
    }
    

    /**
     * @Rest\Delete("/inscrits/{inscritId}",name="delete_inscrit")
     */
    public function deleteInscrit($inscritId)
    {
        return $this->deleteAction($inscritId,  $this->modelType);
    }

}