<?php

namespace App\Controller;

use App\Component\Handler\PartieHandler;
use App\Component\Hydrator\PartieHydrator;
use App\Component\Serializer\CustomSerializer;
use App\Entity\Concept\Fiction;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class PartieController extends FOSRestController
{

    /**
     * @Rest\Get("parties/{id}", name="get_partie")
     */
    public function getPartie($id)
    {
        $em = $this->getDoctrine()->getManager();
        $partie = $em->getRepository('App:Element\Partie')->findOneById($id);

        if (!$partie) {
            throw $this->createNotFoundException(sprintf(
                'Aucune partie avec l\'id "%s" n\'a été trouvée',
                $id
            ));
        }

        $partieHydrator = new PartieHydrator();
        $partieIO = $partieHydrator->hydratePartie($partie);

        $serializer = new CustomSerializer();
        $partieIO = $serializer->serialize($partieIO);

        $response = new Response($partieIO);
        $response->headers->set('Content-Type', 'application/json', 201);

        return $response;
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