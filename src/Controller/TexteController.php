<?php

namespace App\Controller;

use App\Component\Fetcher\TexteFetcher;
use App\Component\Handler\TexteHandler;
use App\Component\IO\TexteIO;
use App\Component\Transformer\TexteTransformer;
use App\Component\Serializer\CustomSerializer;
use App\Form\TexteType;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;

class TexteController extends BaseController
{

    /**
     * @Rest\Get("textes/{texteId}", name="get_texte")
     */
    public function getTexte($texteId)
    {
        $texteIO = $this->getHandler()->getTexte($texteId);
        $response = new Response($texteIO); //todo : replace by a function
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Rest\Get("textes/fiction/{fictionId}", name="get_textes")
     */
    public function getTextes(Request $request, $fictionId)
    {
        //remplacer la valeur en dure pour fictionId
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
                $this->createRoute('get_texte', $texteIO->getId()) //todo : replace by generateUrl()
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
            $this->createRoute('get_texte', $texteIO->getId()) //todo : replace by generateUrl()
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

    /**
     * @param $id
     * @return string
     */
    public function createRoute($routeName, $id)
    {
        $url = $this->generateUrl(
            $routeName, array(
            'texteId' => $id
        ));

        return $url;
    }

}