<?php

namespace App\Controller;

use App\Component\Constant\ModelType;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

class PartieController extends BaseController
{
    /**
     * @var string
     */
    public $modelType = ModelType::PARTIE;

    /**
     * @Rest\Get("parties/{partieId}", name="get_partie")
     */
    public function getPartie($partieId)
    {
        return $this->getAction($partieId, $this->modelType);
    }

    /**
     * @Rest\Get("parties/fiction/{fictionId}", name="get_parties")
     */
    public function getParties(Request $request, $fictionId)
    {
        return $this->createApiResponse(
            $this->getHandler($this->modelType)->getElementsCollection($request, $fictionId, $this->modelType),
            200,
            $this->getHandler($this->modelType)->generateUrl('get_parties', ['fictionId' => $fictionId], $request->query->get('page', 1))
        );
    }

    /**
     * @Rest\Post("parties", name="post_partie")
     */
    public function postPartie(Request $request)
    {
        return $this->postAction($request, $this->modelType);
    }

    /**
     * @Rest\Put("parties/{partieId}", name="put_partie")
     */
    public function putPartie(Request $request, $partieId)
    {
        return $this->putAction($request, $partieId, $this->modelType);
    }

    /**
     * @Rest\Delete("/parties/{partieId}",name="delete_partie")
     */
    public function deletePartie($partieId)
    {
        return $this->deleteAction($partieId, $this->modelType);
    }
}
