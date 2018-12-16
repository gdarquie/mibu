<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Component\Constant\ModelType;

class TexteController extends BaseController
{
    /**
     * @var string
     */
    public $modelType = ModelType::TEXTE;

    /**
     * @Rest\Get("textes/{texteId}", name="get_texte")
     */
    public function getTexte($texteId)
    {
        return $this->getAction($texteId, $this->modelType);
    }

    /**
     * @Rest\Get("textes/fiction/{fictionId}", name="get_textes")
     */
    public function getTextes(Request $request, $fictionId)
    {
        return $this->createApiResponse(
            $this->getHandler($this->modelType)->getElementsCollection($request, $fictionId, $this->modelType),
            200,
            $this->getHandler($this->modelType)->generateUrl('get_textes', ['fictionId' => $fictionId], $request->query->get('page', 1))
        );
    }

    /**
     * @Rest\Post("textes", name="post_texte")
     */
    public function postTexte(Request $request)
    {
        return $this->postAction($request, $this->modelType);
    }

    /**
     * @Rest\Put("textes/{texteId}", name="put_texte")
     */
    public function putTexte(Request $request, $texteId)
    {
        return $this->putAction($request, $texteId, $this->modelType);
    }

    /**
     * @Rest\Delete("/textes/{texteId}",name="delete_texte")
     */
    public function deleteTexte($texteId)
    {
        return $this->deleteAction($texteId, $this->modelType);
    }
}
