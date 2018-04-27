<?php

namespace App\Controller;

use App\Component\Handler\EvenementHandler;
use App\Component\Hydrator\EvenementHydrator;
use App\Component\Serializer\CustomSerializer;
use App\Entity\Concept\Fiction;
use App\Entity\Item\Evenement;
use App\Form\EvenementType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;

class EvenementController extends FOSRestController
{

    /**
     * @Rest\Get("evenements/{evenementId}", name="get_evenement")
     */
    public function getEvenement($evenementId)
    {
        $em = $this->getDoctrine()->getManager();
        $evenement = $em->getRepository(Evenement::class)->findOneById($evenementId);

        if (!$evenement) {
            throw $this->createNotFoundException(sprintf(
                'Aucun évènement avec l\'id "%s" n\'a été trouvé',
                $evenementId
            ));
        }

        $evenementHydrator = new EvenementHydrator();
        $evenementIO = $evenementHydrator->hydrateEvenement($em, $evenement);

        $serializer = new CustomSerializer();
        $evenementIO = $serializer->serialize($evenementIO);

        //ajouter la fiction?

        $response = new Response($evenementIO);
        $response->headers->set('Content-Type', 'application/json', 201);

        return $response;
    }

    /**
     * @Rest\Post("evenements/fiction={fictionId}", name="post_evemement")
     */
    public function postEvenement(Request $request, $fictionId)
    {
        $em = $this->getDoctrine()->getManager();
        $fiction = $em->getRepository(Fiction::class)->findOneById($fictionId);

        if(!$fiction) {
            throw $this->createNotFoundException(sprintf(
                'Aucune fiction avec l\'id "%s" n\'a été trouvé',
                $fictionId
            ));
        }

        $data = json_decode($request->getContent(), true);

        $handlerEvenement = new EvenementHandler();
        $evenement = $handlerEvenement->createEvenement($em, $data, $fiction);

        $response = new JsonResponse('Evènement sauvegardé', 201);
        $evenementUrl = $this->generateUrl(
            'get_evenement', array(
            'evenementId' => $evenement->getId()
        ));

        $response->headers->set('Location', $evenementUrl);
        return $response;

    }

    /**
     * @Rest\Put("/evenements/{evenementId}",name="put_evenement")
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

            $response = new JsonResponse("Mise à jour de l\'évènement ".$evenementId, 202);

            $evenementUrl = $this->generateUrl(
                'get_evenement', array(
                'evenementId' => $evenement->getId()
            ));

            $response->headers->set('Location', $evenementUrl);
        return $response;
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

        return new JsonResponse('Suppression de l\'évènement ' . $evenementId . '.', 202);
    }

}