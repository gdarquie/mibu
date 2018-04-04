<?php

namespace App\Controller;

use App\Component\Handler\PersonnageHandler;
use App\Entity\Concept\Fiction;
use App\Entity\Item\Personnage;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;


class PersonnageController extends FOSRestController
{

    /**
     * @Rest\Get("personnages/{personnageId}", name="get_personnage")
     */
    public function getTexte($personnageId)
    {
        $em = $this->getDoctrine()->getManager();
        $personnage = $em->getRepository(Personnage::class)->findOneById($personnageId);

        if (!$personnage) {
            throw $this->createNotFoundException(sprintf(
                'Aucun personnage avec l\'id "%s" n\'a été trouvé',
                $personnageId
            ));
        }

        $personnageIO = new PersonnageIO();

        return new JsonResponse('Exemple de personnage', 201);
    }

    /**
     * @Rest\Post("personnages/fiction={fictionId}", name="post_personnage")
     */
    public function postTexte(Request $request, $fictionId)
    {
        $data = json_decode($request->getContent(), true);

        $em = $this->getDoctrine()->getManager();
        $fiction = $em->getRepository(Fiction::class)->findOneById($fictionId);

        $handlerPersonnage = new PersonnageHandler();
        $handlerPersonnage->createPersonnage($em, $data, $fiction);

        $response = new JsonResponse('Personnage sauvegardé', 201);

        return $response;

    }

    public function putPersonnage(Request $request)
    {
        //modifier un texte existant
    }

    public function deletePersonnage()
    {
        
    }
}