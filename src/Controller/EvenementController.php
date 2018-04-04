<?php

namespace App\Controller;


use App\Component\Handler\EvenementHandler;
use App\Entity\Concept\Fiction;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;


class EvenementController extends FOSRestController
{

    /**
     * @Rest\Get("evenements/{personnageId}", name="get_personnage")
     */
    public function getEvenement($personnageId)
    {
        $em = $this->getDoctrine()->getManager();

        return new JsonResponse('Exemple d\'évènement', 201);
    }

    /**
     * @Rest\Post("evenements/fiction={fictionId}", name="post_personnage")
     */
    public function postEvenement(Request $request, $fictionId)
    {
        $data = json_decode($request->getContent(), true);

        $em = $this->getDoctrine()->getManager();
        $fiction = $em->getRepository(Fiction::class)->findOneById($fictionId);

        $handlerEvenement = new EvenementHandler();
        $handlerEvenement->createEvenement($em, $data, $fiction);

        $response = new JsonResponse('Evènement sauvegardé', 201);

        return $response;

    }

    public function putEvenement(Request $request)
    {
        //modifier un texte existant
    }

    public function deleteEvenement()
    {
        
    }
}