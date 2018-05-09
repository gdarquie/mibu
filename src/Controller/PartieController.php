<?php

namespace App\Controller;

use App\Component\Handler\PartieHandler;
use App\Entity\Concept\Fiction;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class PartieController extends FOSRestController
{
    public function getPartie()
    {
        return Response("Hello");
    }

    /**
     * @Rest\Post("parties/fiction={fictionId}", name="post_partie")
     */
    public function postPartie(Request $request, $fictionId)
    {
        $data = json_decode($request->getContent(), true);

        $em = $this->getDoctrine()->getManager();
        $fiction = $em->getRepository(Fiction::class)->findOneById($fictionId);

        $handlerPartie = new PartieHandler();
        $partie = $handlerPartie->createPartie($em, $data, $fiction);
        $response = new JsonResponse('Partie sauvegardée', 201);

        $partieUrl = '/partie/1';
//        $partieUrl = $this->generateUrl(
//            'get_partie', array(
//            'partieId' => $partie->getId()
//        ));

        $response->headers->set('Location', $partieUrl);

        return $response;

    }

}