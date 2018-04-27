<?php

namespace App\Controller;

use App\Component\Handler\PersonnageHandler;
use App\Component\Hydrator\PersonnageHydrator;
use App\Component\Serializer\CustomSerializer;
use App\Entity\Concept\Fiction;
use App\Entity\Item\Personnage;
use App\Form\PersonnageType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;


class PersonnageController extends FOSRestController
{
    /**
     * @Rest\Get("personnages/{personnageId}", name="get_personnage")
     */
    public function getPersonnage($personnageId)
    {
        $em = $this->getDoctrine()->getManager();
        $personnage = $em->getRepository(Personnage::class)->findOneById($personnageId);

        if (!$personnage) {
            throw $this->createNotFoundException(sprintf(
                'Aucun personnage avec l\'id "%s" n\'a été trouvé',
                $personnageId
            ));
        }

        $personnageHydrator = new PersonnageHydrator();
        $personnageIO = $personnageHydrator->hydratePersonnage($em, $personnage);

        $serializer = new CustomSerializer();
        $personnageIO = $serializer->serialize($personnageIO);

        //ajouter la fiction?

        $response = new Response($personnageIO);
        $response->headers->set('Content-Type', 'application/json', 201);

        return $response;
    }

    /**
     * @Rest\Post("personnages/fiction={fictionId}", name="post_personnage")
     */
    public function postPersonnage(Request $request, $fictionId)
    {
        $data = json_decode($request->getContent(), true);

        $em = $this->getDoctrine()->getManager();
        $fiction = $em->getRepository(Fiction::class)->findOneById($fictionId);

        $handlerPersonnage = new PersonnageHandler();
        $personnage = $handlerPersonnage->createPersonnage($em, $data, $fiction);

        $response = new JsonResponse('Personnage sauvegardé', 201);

        $personnageUrl = $this->generateUrl(
            'get_personnage', array(
            'personnageId' => $personnage->getId()
        ));

        $response->headers->set('Location', $personnageUrl);

        return $response;

    }

    /**
     * @Rest\Put("personnages/{personnageId}", name="put_personnage")
     */
    public function putPersonnage(Request $request, $personnageId)
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

            $response = new JsonResponse("Mise à jour du personnage", 202);

            $personnageUrl = $this->generateUrl(
                'get_personnage', array(
                'personnageId' => $personnage->getId()
            ));

            $response->headers->set('Location', $personnageUrl);

            return $response;
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