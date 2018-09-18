<?php

namespace App\Controller;

use App\Component\Constant\ModelType;
use App\Component\Handler\LieuHandler;
use App\Component\IO\LieuIO;
use App\Form\LieuType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;


class LieuController extends BaseController
{
    /**
     * @Rest\Get("lieux/{lieuId}", name="get_lieu")
     */
    public function getLieu($lieuId)
    {
        $lieuIO = $this->getHandler()->getEntity($lieuId, ModelType::LIEU);

        return $this->createApiResponse(
            $lieuIO,
            200,
            $this->getHandler()->generateSimpleUrl('get_lieu', ['lieuId' => $lieuId])
        );
    }

    /**
     * @Rest\Get("lieux/fiction/{fictionId}", name="get_lieux")
     */
    public function getLieux(Request $request, $fictionId)
    {
        return $this->createApiResponse(
            $this->getHandler()->getElementsCollection($request, $fictionId, ModelType::LIEU),
            200,
            $this->getHandler()->generateUrl('get_lieux', ['fictionId' => $fictionId], $request->query->get('page', 1))
        );
    }

    /**
     * @Rest\Post("lieux", name="post_lieu")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function postLieu(Request $request)
    {
        $data = $this->getData($request);
        $lieuIO = new LieuIO();
        $form = $this->createForm(LieuType::class, $lieuIO);
        $form->submit($data);

        if($form->isSubmitted()) {  //remplacer par isValidate

            $lieuIO = $this->getHandler()->postEntity($data, ModelType::LIEU);

            return $this->createApiResponse(
                $lieuIO,
                200,
                $this->getHandler()->generateSimpleUrl('get_lieu', ['lieuId' => $lieuIO->getId()])
            );
        }

        return new JsonResponse("Echec de l'insertion", 500);
    }

    /**
     * @Rest\Put("lieux/{lieuId}", name="put_lieu")
     *
     * @param Request $request
     * @param $lieuId
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function putLieu(Request $request, $lieuId)
    {
        $data = $this->getData($request);
        $lieuIO = $this->getHandler()->putEntity($lieuId, $data, ModelType::LIEU);

        return $this->createApiResponse(
            $lieuIO,
            202,
            $this->getHandler()->generateSimpleUrl('get_lieu', ['lieuId' => $lieuIO->getId()])
        );
    }

    /**
     * @Rest\Delete("/lieux/{lieuId}",name="delete_lieu")
     */
    public function deleteLieu($lieuId)
    {
        return $this->getHandler()->deleteEntity($lieuId, ModelType::LIEU);
    }

    /**
     * @return LieuHandler
     */
    public function getHandler()
    {
        return new LieuHandler($this->getDoctrine()->getManager(), $this->get('router'));
    }


}