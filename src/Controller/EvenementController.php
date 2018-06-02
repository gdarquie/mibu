<?php

namespace App\Controller;

use App\Component\Handler\EvenementHandler;
use App\Component\Hydrator\EvenementHydrator;
use App\Component\Serializer\CustomSerializer;
use App\Entity\Concept\Fiction;
use App\Entity\Element\Evenement;
use App\Form\EvenementType;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
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
        $evenementIO = $evenementHydrator->hydrateEvenement($evenement);

        $serializer = new CustomSerializer();
        $evenementIO = $serializer->serialize($evenementIO);

        //ajouter la fiction?

        $response = new Response($evenementIO);
        $response->headers->set('Content-Type', 'application/json', 201);

        return $response;
    }


    /**
     * @Rest\Get("evenements/fiction/{fictionId}", name="get_evenements")
     */
    public function getEvenements($fictionId, $page = 1, $maxPerPage = 10)
    {
        $em = $this->getDoctrine()->getManager();
        $evenementHydrator = new EvenementHydrator();

        $evenements = $em->getRepository(Fiction::class)->getEvenementsFiction($fictionId);

        if (!$evenements) {
            throw $this->createNotFoundException(sprintf(
                'Il n\'y a pas d\'èvenements pour la fiction dont l\'id est "%s" ',
                $fictionId
            ));
        }

        $evenementsIO = [];

        $adapter = new ArrayAdapter($evenements);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage($maxPerPage);
        $pagerfanta->setCurrentPage($page);

        foreach ($pagerfanta as $evenement){
            $evenementIO = $evenementHydrator->hydrateEvenement($evenement);

            array_push($evenementsIO, $evenementIO);
        }

        $total = $pagerfanta->getNbResults();
        $count = count($evenementsIO);

        $serializer = new CustomSerializer();
        $evenementsIO = $serializer->serialize($evenementsIO);

        $response = new Response($evenementsIO);

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Rest\Post("evenements", name="post_evemement")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function postEvenement(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $em = $this->getDoctrine()->getManager();

        $handlerEvenement = new EvenementHandler();
        $evenement = $handlerEvenement->createEvenement($em, $data);

        $response = $this->getEvenement($evenement->getId());

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
     * @Rest\Delete("/evenements/{evenementId}",name="delete_evenement")
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

        return $this->getEvenements($evenement->getFiction()->getId());
//        return new JsonResponse('Suppression de l\'évènement ' . $evenementId . '.', 202);
    }

    /**
     * @Rest\Delete("/personnages/{personnageId}",name="delete_personnage")
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

        return $this->getPersonnages($personnage->getFiction()->getId());
    }

}