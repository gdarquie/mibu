<?php

namespace App\Controller;

use App\Component\Constant\ModelType;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

class EvenementController extends BaseController
{
    /**
     * @var string
     */
    public $modelType = ModelType::EVENEMENT;

    /**
     * @Rest\Get("evenements/{evenementId}", name="get_evenement")
     */
    public function getEvenement($evenementId)
    {
        return $this->getAction($evenementId, $this->modelType);
    }

    /**
     * @Rest\Get("evenements/fiction/{fictionId}", name="get_evenements")
     */
    public function getParties(Request $request, $fictionId)
    {
        return $this->createApiResponse(
            $this->getHandler($this->modelType)->getElementsCollection($request, $fictionId, $this->modelType),
            200,
            $this->getHandler($this->modelType)->generateUrl('get_evenements', ['fictionId' => $fictionId], $request->query->get('page', 1))
        );
    }

    /**
     * @Rest\Post("evenements", name="post_evemement")
     */
    public function postEvenement(Request $request)
    {
        return $this->postAction($request, $this->modelType);
    }

    /**
     * @Rest\Put("/evenements/{evenementId}",name="put_evenement")
     */
    public function putEvenement(Request $request, $evenementId)
    {
        return $this->putAction($request, $evenementId, $this->modelType);
    }

    /**
     * @Rest\Delete("/evenements/{evenementId}",name="delete_evenement")
     */
    public function deleteEvenement($evenementId)
    {
        return $this->deleteAction($evenementId, $this->modelType);
    }
}
