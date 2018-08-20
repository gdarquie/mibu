<?php

namespace App\Controller;

use App\Component\Handler\FictionHandler;
use App\Component\IO\FictionIO;
use App\Entity\Concept\Fiction;
use App\Form\FictionType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;

class FictionController extends FOSRestController
{
    /**
     * @Rest\Get("fictions", name="get_fictions")
     */
    public function getFictions(): Response
    {
        return $this->getResponse(
            $this->getHandler()->getFictions($page = 1, $maxPerPage = 10)
        );
    }

    /**
     * @Rest\Get("fictions/{id}", name="get_fiction")
     */
    public function getFiction($id): Response
    {
        return $this->getResponse(
            $this->getHandler()->getFiction($id)
        );
    }

    /**
     * @Rest\Post("fictions", name="post_fiction")
     *
     * @param Request $request
     * @return JsonResponse|Response
     */
    public function postFiction(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $fictionIO = new FictionIO();
        $form = $this->createForm(FictionType::class, $fictionIO);
        $form->submit($data);

        if($form->isSubmitted()) {  //remplacer par isValidate

            $fictionIO = $this->getHandler()->postFiction($data);

            //refacto la génération de route
            $url = $this->generateUrl(
                'get_fiction', array(
                'id' => json_decode($fictionIO)->id
            ));

//            $this->createRouteWithId($id);

            $response = $this->getResponse($fictionIO, $url);

            return $response;
        }

        return new JsonResponse("Echec de l'insertion", 500);
    }

    /**
     * @Rest\Put("fictions/{fictionId}", name="put_fiction")
     */
    public function putFiction(Request $request, $fictionId)
    {
        $data = json_decode($request->getContent(), true);

        $fictionIO = $this->getHandler()->putFiction($fictionId, $data);

        //create response
        $url = $this->createRouteGetFiction($fictionId);
        $response = $this->getResponse($fictionIO, $url);

        return $response;

    }

    /**
     * @Rest\Delete("/fictions/{fictionId}",name="delete_fiction")
     */
    public function deleteAction(Request $request, $fictionId)
    {

        $em = $this->getDoctrine()->getManager();

        $fiction = $this->getDoctrine()->getRepository(Fiction::class)->findOneById($fictionId);

        if (!$fiction) {
            throw $this->createNotFoundException(sprintf(
                'Aucune fiction avec l\'id "%s" n\'a été trouvée',
                $fictionId
            ));
        }

        $em->remove($fiction);
        $em->flush();

        return new JsonResponse('Suppression de la fiction '.$fictionId.'.', 202);
    }

    public function getHandler()
    {
        $fictionHandler = new FictionHandler($this->getDoctrine()->getManager());
        return $fictionHandler;
    }

    public function getResponse($io, $url = null)
    {
        $response = new Response($io);
        $response->headers->set('Content-Type', 'application/json');

        if (isset($url)) {
            $response->headers->set('Location', $url);
        }

        return $response;
    }

    public function createRouteGetFiction($id)
    {
        $url = $this->generateUrl(
            'get_fiction', array(
            'id' => $id
        ));

        return $url;
    }

}