<?php

namespace App\Controller;

use App\Component\Constant\ModelType;
use App\Component\Handler\FictionHandler;
use App\Component\IO\FictionIO;
use App\Form\FictionType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

class FictionController extends BaseController
{
    /**
     * @Rest\Get("fictions", name="get_fictions")
     */
    public function getFictions(Request $request): Response
    {
        return $this->createApiResponse(
            $this->getHandler()->getConceptsCollection($request, ModelType::FICTION),
            200,
            $this->getHandler()->generateUrl('get_fictions', [], $request->query->get('page', 1))
        );
    }

    /**
     * @Rest\Get("fictions/{fictionId}", name="get_fiction")
     */
    public function getFiction($fictionId): Response
    {
        $fictionIO = $this->getHandler()->getEntity($fictionId, ModelType::FICTION);

        return $this->createApiResponse(
            $fictionIO,
            200,
            $this->getHandler()->generateSimpleUrl('get_fiction', ['fictionId' => $fictionId])
        );

    }

    /**
     * @Rest\Post("fictions", name="post_fiction")
     *
     *
     * @param Request $request
     * @return JsonResponse|Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function postFiction(Request $request)
    {
        $data = $this->getData($request);
        $fictionIO = new FictionIO();
        $form = $this->createForm(FictionType::class, $fictionIO);
        $form->submit($data);

        if($form->isSubmitted()) {  //remplacer par isValidate

            $fictionIO = $this->getHandler()->postEntity($data, ModelType::FICTION);

            return $this->createApiResponse(
                $fictionIO,
                202,
                $this->getHandler()->generateSimpleUrl('get_fiction', ['fictionId' => $fictionIO->getId()])
            );
        }

        return new JsonResponse("Echec de l'insertion", 500);
    }

    /**
     * @Rest\Put("fictions/{fictionId}", name="put_fiction")
     */
    public function putFiction(Request $request, $fictionId)
    {
        $data = $this->getData($request);
        $fictionIO = $this->getHandler()->putEntity($fictionId, $data, ModelType::FICTION);

        return $this->createApiResponse(
            $fictionIO,
            202,
            $this->getHandler()->generateSimpleUrl('get_fiction', ['fictionId' => $fictionIO->getId()])
        );

    }

    /**
     * @Rest\Delete("/fictions/{fictionId}",name="delete_fiction")
     *
     * @param $fictionId
     * @return JsonResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function deleteFiction($fictionId)
    {
        return $this->getHandler()->deleteEntity($fictionId, ModelType::FICTION);
    }

    /**
     * @return FictionHandler
     */
    public function getHandler()
    {
        return new FictionHandler($this->getDoctrine()->getManager(), $this->get('router'));
    }

    /**
     * @param $io
     * @param null $url
     * @return Response
     */
    public function createResponse($io, $url = null)
    {
        $response = new Response($io);
        $response->headers->set('Content-Type', 'application/json');

        if (isset($url)) {
            $response->headers->set('Location', $url);
        }

        return $response;
    }

    /**
     * @param $id
     * @return string
     */
    public function createRouteGetFiction($id)
    {
        $url = $this->generateUrl(
            'get_fiction', array(
            'fictionId' => $id
        ));

        return $url;
    }

}