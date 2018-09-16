<?php

namespace App\Controller;

use App\Component\Constant\ModelType;
use App\Component\Handler\EvenementHandler;
use App\Component\IO\EvenementIO;
use App\Form\EvenementType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

class EvenementController extends BaseController
{
    /**
     * @Rest\Get("evenements/{evenementId}", name="get_evenement")
     */
    public function getEvenement($evenementId)
    {
        $evenementIO = $this->getHandler()->getEntity($evenementId, ModelType::EVENEMENT);

        return $this->createApiResponse(
            $evenementIO,
            200,
            $this->getHandler()->generateSimpleUrl('get_evenement', ['evenementId' => $evenementId])
        );
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

        $data = $this->getData($request);
        $evenementIO = new EvenementIO();
        $form = $this->createForm(EvenementType::class, $evenementIO);
        $form->submit($data);

        if($form->isSubmitted()) {  //remplacer par isValidate

            $evenementIO = $this->getHandler()->postEntity($data, ModelType::EVENEMENT);

            return $this->createApiResponse(
                $evenementIO,
                200,
                $this->getHandler()->generateSimpleUrl('get_evenement', ['evenementId' => $evenementIO->getId()])
            );
        }

        return new JsonResponse("Echec de l'insertion", 500);
    }

    /**
     * @Rest\Put("/evenements/{evenementId}",name="put_evenement")
     */
    public function putEvenement(Request $request,$evenementId)
    {
        $data = $this->getData($request);
        $evenementIO = $this->getHandler()->putEntity($evenementId, $data, modelType::EVENEMENT);

        return $this->createApiResponse(
            $evenementIO,
            202,
            $this->getHandler()->generateSimpleUrl('get_personnage', ['personnageId' => $evenementIO->getId()])
        );
    }

    /**
     * @Rest\Delete("/evenements/{evenementId}",name="delete_evenement")
     */
    public function deleteEvenement($evenementId)
    {
        return $this->getHandler()->deleteEntity($evenementId, modelType::EVENEMENT);

    }

    /**
     * @return EvenementHandler
     */
    public function getHandler()
    {
        return new EvenementHandler($this->getDoctrine()->getManager(), $this->get('router'));
    }

}