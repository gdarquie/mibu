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
        return $this->getAction($lieuId, ModelType::LIEU);

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
     */
    public function postLieu(Request $request)
    {
        return $this->postAction($request, ModelType::LIEU);

    }

    /**
     * @Rest\Put("lieux/{lieuId}", name="put_lieu")
     */
    public function putLieu(Request $request, $lieuId)
    {
        return $this->putAction($request, $lieuId, ModelType::LIEU);
    }

    /**
     * @Rest\Delete("/lieux/{lieuId}",name="delete_lieu")
     */
    public function deleteLieu($lieuId)
    {
        return $this->deleteAction($lieuId, ModelType::LIEU);
    }

    /**
     * @return LieuHandler
     */
    public function getHandler()
    {
        return new LieuHandler($this->getDoctrine()->getManager(), $this->get('router'));
    }


}