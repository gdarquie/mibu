<?php

namespace App\Controller;

use App\Component\Constant\ModelType;
use App\Component\Handler\PartieHandler;
use App\Component\IO\PartieIO;
use App\Form\PartieType;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class PartieController extends BaseController
{

    /**
     * @Rest\Get("parties/{partieId}", name="get_partie")
     */
    public function getPartie($partieId)
    {
        $partieIO = $this->getHandler()->getEntity($partieId, ModelType::PARTIE);

        return $this->createApiResponse(
            $partieIO,
            200,
            $this->getHandler()->generateSimpleUrl('get_partie', ['partieId' => $partieId])
        );
    }

    /**
     * @Rest\Get("parties/fiction/{fictionId}", name="get_parties")
     */
    public function getParties(Request $request, $fictionId)
    {
        return $this->createApiResponse(
            $this->getHandler()->getElementsCollection($request, $fictionId, ModelType::PARTIE),
            200,
            $this->getHandler()->generateUrl('get_parties', ['fictionId' => $fictionId], $request->query->get('page', 1))
        );
    }

    /**
     * @Rest\Post("parties", name="post_partie")
     *
     * @param Request $request
     * @return JsonResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function postPartie(Request $request)
    {
        $data = $this->getData($request);
        $partieIO = new PartieIO();
        $form = $this->createForm(PartieType::class, $partieIO);
        $form->submit($data);

        if($form->isSubmitted()) {  //remplacer par isValidate

            $partieIO = $this->getHandler()->postEntity($data, ModelType::PARTIE);

            return $this->createApiResponse(
                $partieIO,
                200,
                $this->getHandler()->generateSimpleUrl('get_partie', ['partieId' => $partieIO->getId()])
            );
        }

        return new JsonResponse("Echec de l'insertion", 500);
    }


    /**
     * @Rest\Put("parties/{partieId}", name="put_partie")
     */
    public function putPartie(Request $request, $partieId)
    {
        $data = $this->getData($request);
        $partieIO = $this->getHandler()->putEntity($partieId, $data, ModelType::PARTIE);

        return $this->createApiResponse(
            $partieIO,
            202,
            $this->getHandler()->generateSimpleUrl('get_partie', ['partieId' => $partieIO->getId()])
        );
    }

    /**
     * @Rest\Delete("/parties/{partieId}",name="delete_partie")
     */
    public function deletePartie($partieId)
    {
        return $this->getHandler()->deleteEntity($partieId, ModelType::PARTIE);
    }

    /**
     * @return PartieHandler
     */
    public function getHandler()
    {
        return new PartieHandler($this->getDoctrine()->getManager(), $this->get('router'));
    }

}