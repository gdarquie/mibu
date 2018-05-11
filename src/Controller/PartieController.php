<?php

namespace App\Controller;

use App\Component\Handler\PartieHandler;
use App\Component\Hydrator\PartieHydrator;
use App\Component\Serializer\CustomSerializer;
use App\Entity\Concept\Fiction;
use App\Entity\Element\Partie;
use App\Form\PartieType;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class PartieController extends FOSRestController
{

    /**
     * @Rest\Get("parties", name="get_parties")
     */
    public function getParties()
    {
        $em = $this->getDoctrine()->getManager();
        $partieHydrator = new PartieHydrator();
        $parties = $em->getRepository(Partie::class)->findAll();
        $partiesIO = [];

        foreach ($parties as $partie){
            $partieIO = $partieHydrator->hydratePartie($partie);
            array_push($partiesIO, $partieIO);
        }
        $serializer = new CustomSerializer();
        $partiesIO = $serializer->serialize($partiesIO);

        $response = new Response($partiesIO);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

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

        $partieUrl = $this->generateUrl(
            'get_partie', array(
            'id' => $partie->getId()
        ));

        $response->headers->set('Location', $partieUrl);

        return $response;

    }

    /**
     * @Rest\Put("parties/{partieId}", name="put_partie")
     */
    public function putPartie(Request $request, $partieId)
    {
        $em = $this->getDoctrine()->getManager();

        $partie = $this->getDoctrine()
            ->getRepository(Partie::class)
            ->findOneById($partieId);

        if (!$partie) {
            throw $this->createNotFoundException(sprintf(
                'Pas de partie trouvée avec l\'id "%s"',
                $partieId
            ));
        }

        $data = json_decode($request->getContent(), true);

        $form = $this->createForm(PartieType::class, $partie);
        $form->submit($data);

        if($form->isSubmitted()){
            $em->persist($partie);
            $em->flush();

            $response = new JsonResponse("Mise à jour de la partie", 202);
            $partieUrl = $this->generateUrl(
                'get_partie', array(
                'id' => $partie->getId()
            ));

            $response->headers->set('Location', $partieUrl);

            return $response;

        }

        return new JsonResponse("Echec de la mise à jour");
    }

    /**
     * @Rest\Delete("/parties/{partieId}",name="delete_partie")
     */
    public function deletePartie($partieId)
    {
        $em = $this->getDoctrine()->getManager();

        $partie = $this->getDoctrine()->getRepository(Partie::class)->findOneById($partieId);

        if (!$partie) {
            throw $this->createNotFoundException(sprintf(
                'Pas de partie trouvée avec l\'id "%s"',
                $partieId
            ));
        }

        $em->remove($partie);
        $em->flush();

        return new JsonResponse('Suppression de la partie '.$partieId.'.', 202);
    }

}