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
        $texteIO = $this->getHandler()->getEntity($texteId, modelType::TEXTE);

        return $this->createApiResponse(
            $texteIO,
            200,
            $this->getHandler()->generateSimpleUrl('get_texte', ['texteId' => $texteId])
            );
    }

    /**
     * @Rest\Get("textes/fiction/{fictionId}", name="get_textes")
     */
    public function getTextes(Request $request, $fictionId)
    {
        return $this->createApiResponse(
            $this->getHandler()->getTextes($request, $fictionId),
            200,
            $this->getHandler()->generateUrl('get_textes', ['fictionId' => $fictionId], $request->query->get('page', 1))
        );
    }

    /**
     * @Rest\Post("textes", name="post_texte")
     */
    public function postTexte(Request $request)
    {
        $data = $this->getData($request);
        $texteIO = new TexteIO();
        $form = $this->createForm(TexteType::class, $texteIO);
        $form->submit($data);

        if($form->isSubmitted()) {  //remplacer par isValidate

            $texteIO = $this->getHandler()->postTexte($data);

            return $this->createApiResponse(
                $texteIO,
                200,
                $this->getHandler()->generateSimpleUrl('get_texte', ['texteId' => $texteIO->getId()])
            );
        }

        return new JsonResponse("Echec de l'insertion", 500);

    }

    /**
     * @Rest\Put("textes/{texteId}", name="put_texte")
     */
    public function putTexte(Request $request, $texteId)
    {
        $data = $this->getData($request);
        $texteIO = $this->getHandler()->putTexte($texteId, $data);

        return $this->createApiResponse(
            $texteIO,
            202,
            $this->getHandler()->generateSimpleUrl('get_texte', ['texteId' => $texteIO->getId()])
        );
    }

    /**
     * @Rest\Delete("/textes/{texteId}",name="delete_texte")
     */
    public function deleteAction($texteId)
    {
        return $this->getHandler()->deleteTexte($texteId);
    }

    /**
     * @return TexteHandler
     */
    public function getHandler()
    {
        return new TexteHandler($this->getDoctrine()->getManager(), $this->get('router'));
    }

}
