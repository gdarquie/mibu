<?php

namespace App\Controller;

use App\Component\Handler\PersonnageHandler;
use App\Component\Hydrator\PersonnageHydrator;
use App\Component\Serializer\CustomSerializer;
use App\Entity\Concept\Fiction;
use App\Entity\Element\Personnage;
use App\Form\PersonnageType;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
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
        $personnageIO = $personnageHydrator->hydratePersonnage($personnage);

        $serializer = new CustomSerializer();
        $personnageIO = $serializer->serialize($personnageIO);

        $response = new Response($personnageIO);
        $response->headers->set('Content-Type', 'application/json', 201);

        return $response;
    }

    /**
     * @Rest\Get("personnages/fiction/{fictionId}", name="get_personnages")
     */
    public function getPersonnages($fictionId, $page = 1, $maxPerPage = 10)
    {
        $em = $this->getDoctrine()->getManager();
        $personnages = $em->getRepository(Fiction::class)->getPersonnagesFiction($fictionId);

        if (!$personnages) {
            throw $this->createNotFoundException(sprintf(
                'Aucun personnage n\'a été trouvé pour la fiction "%s"',
                $fictionId
            ));
        }

        $personnageHydrator = new PersonnageHydrator();
        $personnagesIO = [];
        $adapter = new ArrayAdapter($personnages);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage($maxPerPage);
        $pagerfanta->setCurrentPage($page);

        foreach ($pagerfanta as $personnage){
            $personnageIO = $personnageHydrator->hydratePersonnage($personnage);

            array_push($personnagesIO, $personnageIO);
        }

        $serializer = new CustomSerializer();
        $personnagesIO = $serializer->serialize($personnagesIO);

        $response = new Response($personnagesIO);

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Rest\Post("personnages", name="post_personnage")
     */
    public function postPersonnage(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $em = $this->getDoctrine()->getManager();

        $handlerPersonnage = new PersonnageHandler();
        $personnage = $handlerPersonnage->createPersonnage($em, $data);

        $response = $this->getPersonnage($personnage->getId());

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