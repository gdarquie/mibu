<?php

namespace App\Controller;

use App\Component\Constant\ModelType;
use App\Component\Handler\EvenementHandler;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

class EvenementController extends BaseController
{
    /**
     * @Rest\Get("evenements/{evenementId}", name="get_evenement")
     */
    public function getEvenement($evenementId)
    {
        return $this->getAction($evenementId, ModelType::EVENEMENT);

    }

    /**
     * @Rest\Get("evenements/fiction/{fictionId}", name="get_evenements")
     */
    public function getParties(Request $request, $fictionId)
    {
        return $this->createApiResponse(
            $this->getHandler()->getElementsCollection($request, $fictionId, ModelType::EVENEMENT),
            200,
            $this->getHandler()->generateUrl('get_evenements', ['fictionId' => $fictionId], $request->query->get('page', 1))
        );
    }

    /**
     * @Rest\Post("evenements", name="post_evemement")
     *
     */
    public function postEvenement(Request $request)
    {
        return $this->postAction($request, ModelType::EVENEMENT);
    }

    /**
     * @Rest\Put("/evenements/{evenementId}",name="put_evenement")
     */
    public function putEvenement(Request $request,$evenementId)
    {
        return $this->putAction($request, $evenementId, ModelType::EVENEMENT);
    }

    /**
     * @Rest\Delete("/evenements/{evenementId}",name="delete_evenement")
     */
    public function deleteEvenement($evenementId)
    {
        return $this->deleteAction($evenementId, ModelType::EVENEMENT);

    }

    /**
     * @return EvenementHandler
     */
    public function getHandler()
    {
        return new EvenementHandler($this->getDoctrine()->getManager(), $this->get('router'));
    }

}