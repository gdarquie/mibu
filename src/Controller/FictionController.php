<?php

namespace App\Controller;

use App\Component\Constant\ModelType;
use App\Component\Handler\FictionHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

class FictionController extends BaseController
{
    /**
     * @Rest\Get("fictions", name="get_fictions")
     */
    public function getFictions(Request $request): Response
    {
        return $this->createApiResponse(
            $this->getHandler()->getConceptsCollection($request, ModelType::FICTION),
            200,
            $this->getHandler()->generateUrl('get_fictions', [], $request->query->get('page', 1))
        );
    }

    /**
     * @Rest\Get("fictions/{fictionId}", name="get_fiction")
     */
    public function getFiction($fictionId): Response
    {
        return $this->getAction($fictionId, ModelType::FICTION);
    }

    /**
     * @Rest\Post("fictions", name="post_fiction")
     */
    public function postFiction(Request $request)
    {
        return $this->postAction($request, ModelType::FICTION);
    }

    /**
     * @Rest\Put("fictions/{fictionId}", name="put_fiction")
     */
    public function putFiction(Request $request, $fictionId)
    {
        return $this->putAction($request, $fictionId, ModelType::FICTION);
    }

    /**
     * @Rest\Delete("/fictions/{fictionId}",name="delete_fiction")
     */
    public function deleteFiction($fictionId)
    {
        return $this->deleteAction($fictionId, ModelType::FICTION);
    }

    /**
     * @return FictionHandler
     */
    public function getHandler()
    {
        return new FictionHandler($this->getDoctrine()->getManager(), $this->get('router'));
    }
}