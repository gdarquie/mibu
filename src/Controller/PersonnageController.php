<?php

namespace App\Controller;

use App\Component\Handler\PersonnageHandler;
use App\Component\IO\PersonnageIO;
use App\Entity\Element\Personnage;
use App\Form\PersonnageType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Component\Constant\ModelType;


class PersonnageController extends BaseController
{
    /**
     * @Rest\Get("personnages/{personnageId}", name="get_personnage")
     */
    public function getPersonnage($personnageId)
    {
        return $this->getAction($personnageId, ModelType::PERSONNAGE);

    }

    /**
     * @Rest\Get("personnages/fiction/{fictionId}", name="get_personnages")
     */
    public function getPersonnages(Request $request, $fictionId)
    {
        return $this->createApiResponse(
            $this->getHandler()->getElementsCollection($request, $fictionId, ModelType::PERSONNAGE),
            200,
            $this->getHandler()->generateUrl('get_textes', ['fictionId' => $fictionId], $request->query->get('page', 1))
        );
    }

    /**
     * @Rest\Post("personnages", name="post_personnage")
     */
    public function postPersonnage(Request $request)
    {
        return $this->postAction($request, ModelType::PERSONNAGE);
    }

    /**
     * @Rest\Put("personnages/{personnageId}", name="put_personnage")
     */
    public function putPersonnage(Request $request, $personnageId)
    {
        return $this->putAction($request, $personnageId, ModelType::PERSONNAGE);

    }

    /**
     * @Rest\Delete("/personnages/{personnageId}", name="delete_personnage")
     */
    public function deletePersonnage($personnageId)
    {
        return $this->deleteAction($personnageId, ModelType::PERSONNAGE);

    }

    /**
     * @Rest\Post("personnages/generation", name="generate_personnages")
     *
     * @param $limite
     * @return array
     */
    public function generatePersonnages($limite=10) :array
    {
        $personnages = [];

        $personnage = new Personnage('Original', 'Le personnage original');

        for($i= 0; $i < $limite; $i++) {
            $clone = clone $personnage;
            //changeId
            $clone->setTitre('Clone n°'.($i+1));
            $clone->setDescription('Un clone');
            $genre = (rand(0,1)>0) ?$genre = 'M' :$genre = 'F';
            $clone->setGenre($genre);
            $clone->setAuto(TRUE);


            array_push($personnages, $clone);

            //save every perso
        }

        dump($personnages);die;

        //ajouter quelque chose dans la bd pour savoir si le perso a été générée?

        //convert into json
        return $personnages;
    }

    //new function for deleting all the generating characters for a fiction
    public function deleteGenerated()
    {
        return 'Deleted';
    }

    /**
     * @return PersonnageHandler
     */
    public function getHandler()
    {
        return new PersonnageHandler($this->getDoctrine()->getManager(), $this->get('router'));
    }
}