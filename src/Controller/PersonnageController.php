<?php

namespace App\Controller;

use App\Component\Handler\PersonnageHandler;
<<<<<<< HEAD
use App\Entity\Concept\Fiction;
use App\Entity\Item\Personnage;
use App\Form\PersonnageType;
=======
use App\Component\IO\PersonnageIO;
use App\Entity\Concept\Fiction;
use App\Entity\Item\Personnage;
>>>>>>> a5f13c03ea52f3c7f4818ff464ba1860fdb39b11
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

<<<<<<< HEAD
    /**
     * @Rest\Put("personnages/{personnageId}", name="put_personnage")
     */
    public function putPersonnage(Request $request, $personnageId)
=======
    public function putPersonnage(Request $request)
>>>>>>> a5f13c03ea52f3c7f4818ff464ba1860fdb39b11
    {
        $em = $this->getDoctrine()->getManager();

        $personnage = $this->getDoctrine()
            ->getRepository(Personnage::class)
            ->findOneById($personnageId);

        if (!$personnage) {
            throw $this->createNotFoundException(sprintf(
                'Pas de personnage trouvé avec l\'id "%s"',
                $personnageId
            ));
        }

        $data = json_decode($request->getContent(), true);

        $form = $this->createForm(PersonnageType::class, $personnage);
        $form->submit($data);

        if($form->isSubmitted()){
            $em->persist($personnage);
            $em->flush();

            return new JsonResponse("Mise à jour du personnage", 200);
        }

        return new JsonResponse("Echec de la mise à jour");
    }

    /**
     * @Rest\Delete("/personnages/{texteId}",name="delete_personnage")
     */
    public function deletePersonnage($personnageId)
    {
        $em = $this->getDoctrine()->getManager();

        $personnage = $this->getDoctrine()->getRepository(Personnage::class)->findOneById($personnageId);

        if (!$personnage) {
            throw $this->createNotFoundException(sprintf(
                'Pas de personnage trouvé avec l\'id "%s"',
                $personnageId
            ));
        }

        $em->remove($personnage);
        $em->flush();

        return new JsonResponse('Suppression du personnage '.$personnageId.'.');
    }
}