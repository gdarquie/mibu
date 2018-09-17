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
     * @return LieuHandler
     */
    public function getHandler()
    {
        return new LieuHandler($this->getDoctrine()->getManager(), $this->get('router'));
    }


}