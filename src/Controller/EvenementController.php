<?php

namespace App\Controller;


use App\Component\Handler\EvenementHandler;
use App\Entity\Concept\Fiction;
<<<<<<< HEAD
use App\Entity\Item\Evenement;
use App\Form\EvenementType;
=======
>>>>>>> a5f13c03ea52f3c7f4818ff464ba1860fdb39b11
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

<<<<<<< HEAD
    /**
     * @Rest\Put("/evenement/{evenementId}",name="delete_evenement")
     */
    public function putEvenement(Request $request,$evenementId)
    {
        $em = $this->getDoctrine()->getManager();

        $evenement = $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->findOneById($evenementId);

        if (!$evenement) {
            throw $this->createNotFoundException(sprintf(
                'Pas d\'évènement trouvé avec l\'id "%s"',
                $evenement
            ));
        }

        $data = json_decode($request->getContent(), true);

        $form = $this->createForm(EvenementType::class, $evenement);
        $form->submit($data);

        if($form->isSubmitted()){
            $em->persist($evenement);
            $em->flush();

            return new JsonResponse("Mise à jour de l\'évènement ".$evenementId, 200);
        }

        return new JsonResponse("Echec de la mise à jour");
    }

    /**
     * @Rest\Delete("/evenement/{evenementId}",name="delete_evenement")
     */
    public function deleteEvenement($evenementId)
    {
        $em = $this->getDoctrine()->getManager();

        $evenement = $this->getDoctrine()->getRepository(Evenement::class)->findOneById($evenementId);

        if (!$evenement) {
            throw $this->createNotFoundException(sprintf(
                'Pas d\'évènement trouvé avec l\'id "%s"',
                $evenement
            ));
        }

        $em->remove($evenement);
        $em->flush();

        return new JsonResponse('Suppression de l\'évènement '.$evenementId.'.');
=======
    public function putEvenement(Request $request)
    {
        //modifier un texte existant
    }

    public function deleteEvenement()
    {
        
>>>>>>> a5f13c03ea52f3c7f4818ff464ba1860fdb39b11
    }
}