<?php

namespace App\Controller;

use App\Component\Handler\TexteHandler;
use App\Component\IO\TexteIO;
use App\Form\TexteType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Component\Constant\ModelType;


class TexteController extends BaseController
{
    /**
     * @Rest\Get("textes/{texteId}", name="get_texte")
     */
    public function getTexte($texteId)
    {
        return $this->getAction($texteId, ModelType::TEXTE);

    }

    /**
     * @Rest\Get("textes/fiction/{fictionId}", name="get_textes")
     */
    public function getTextes(Request $request, $fictionId)
    {
        return $this->createApiResponse(
            $this->getHandler()->getElementsCollection($request, $fictionId, ModelType::TEXTE),
            200,
            $this->getHandler()->generateUrl('get_textes', ['fictionId' => $fictionId], $request->query->get('page', 1))
        );
    }

    /**
     * @Rest\Post("textes", name="post_texte")
     */
    public function postTexte(Request $request)
    {
        return $this->postAction($request, ModelType::TEXTE);
    }

    /**
     * @Rest\Put("textes/{texteId}", name="put_texte")
     */
    public function putTexte(Request $request, $texteId)
    {
        return $this->putAction($request, $texteId, ModelType::TEXTE);
    }

    /**
     * @Rest\Delete("/textes/{texteId}",name="delete_texte")
     */
    public function deleteTexte($texteId)
    {
        return $this->deleteAction($texteId, ModelType::TEXTE);
    }

    /**
     * @return TexteHandler
     */
    public function getHandler()
    {
        return new TexteHandler($this->getDoctrine()->getManager(), $this->get('router'));
    }

}
