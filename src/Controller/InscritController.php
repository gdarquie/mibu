<?php

namespace App\Controller;

use App\Component\Constant\ModelType;
use App\Component\Handler\InscritHandler;
use App\Component\IO\InscritIO;
use App\Form\InscritType;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     *
     *
     * @param Request $request
     * @return JsonResponse|Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function postInscrit(Request $request)
    {
        return $this->postAction($request, ModelType::INSCRIT);
    }

    /**
     * @Rest\Put("inscrits/{inscritId}", name="put_inscrit")
     *
     *
     * @param Request $request
     * @param $inscritId
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function putInscrit(Request $request, $inscritId)
    {
        $data = $this->getData($request);
        $inscritIO = $this->getHandler()->putEntity($inscritId, $data, ModelType::INSCRIT);

        return $this->createApiResponse(
            $inscritIO,
            202,
            $this->getHandler()->generateSimpleUrl('get_inscrit', ['inscritId' => $inscritIO->getId()])
        );
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