<?php

namespace App\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use App\Component\Constant\ModelType;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class RoutineController extends BaseController
{
    /**
     * @Rest\Post("routines/personnage={personnageId}", name="generate_routines_personnage")
     */
    public function generatePersonnageRoutines($personnageId)
    {
        if (!$this->getHandler(ModelType::PERSONNAGE)->handleGenerateRoutines($personnageId)) {
            throw new BadRequestHttpException(sprintf(
                "Une erreur s'est produite, aucune routine n'a été générée."
            ));
        }

        return $this->redirectToRoute('get_personnage', array('personnageId' => $personnageId));
    }

    /**
     * @Rest\Post("routines/fiction={fictionId}", name="generate_routines_fiction")
     */
    public function generateFictionRoutines($personnageId)
    {
    }

    /**
     * @Rest\Get("routines/personnage={personnageId}", name="get_routines_personnage")
     */
    public function getRoutinesPersonnage($personnage)
    {
        //todo : return routines
    }

    /**
     * @Rest\Delete("routines/personnage={personnageId}", name="delete_routines_personnage")
     */
    public function deleteRoutinesPersonnage($personnageId)
    {
        return $this->getHandler(ModelType::PERSONNAGE)->handleDeleteRoutinesPersonnage($personnageId);
    }

    /**
     * @Rest\Delete("routines/fiction={fictionId}", name="delete_routines_fiction")
     */
    public function deleteRoutinesFiction()
    {
    }
}
