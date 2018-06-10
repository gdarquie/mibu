<?php

namespace App\Controller;

use App\Component\Handler\EvenementHandler;
use App\Component\Handler\FictionHandler;

use App\Component\Handler\PersonnageHandler;
use App\Component\Handler\TexteHandler;
use App\Component\Hydrator\FictionHydrator;
use App\Component\Serializer\CustomSerializer;
use App\Entity\Concept\Fiction;
use App\Entity\Modele\AbstractItem;
use App\Form\FictionType;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;


class FictionController extends FOSRestController
{
    /**
     * @Rest\Get("fictions", name="get_fictions")
     */
    public function getFictions(Request $request,$page = 1, $maxPerPage = 10)
    {
        $em = $this->getDoctrine()->getManager();
        $fictionHydrator = new FictionHydrator();

        $fictions = $em->getRepository(Fiction::class)->findAll();
        $fictionsIO = [];

        $adapter = new ArrayAdapter($fictions);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage($maxPerPage);
        $pagerfanta->setCurrentPage($page);

        foreach ($pagerfanta as $fiction){
            $fictionIO = $fictionHydrator->hydrateFiction($em, $fiction);

            array_push($fictionsIO, $fictionIO);
        }

        $total = $pagerfanta->getNbResults();
        $count = count($fictionsIO);

        $serializer = new CustomSerializer();
        $fictionsIO = $serializer->serialize($fictionsIO);

        $response = new Response($fictionsIO);

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }


    /**
     * @Rest\Get("fictions/{id}", name="get_fiction")
     */
    public function getFiction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $fiction = $em->getRepository('App:Concept\Fiction')->findOneById($id);

        if (!$fiction) {
            throw $this->createNotFoundException(sprintf(
                'Aucune fiction avec l\'id "%s" n\'a été trouvée',
                $id
            ));
        }

        $fictionHydrator = new FictionHydrator();
        $fictionIO = $fictionHydrator->hydrateFiction($em, $fiction);

        $serializer = new CustomSerializer();
        $fictionIO = $serializer->serialize($fictionIO);

        $response = new Response($fictionIO);
        $response->headers->set('Content-Type', 'application/json', 201);

        return $response;
    }

    /**
     * @Rest\Post("fictions", name="post_fiction")
     */
    public function postFiction(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $fiction = new Fiction();
        $form = $this->createForm(FictionType::class, $fiction);
        $form->submit($data);

        if($form->isSubmitted()){

            $em = $this->getDoctrine()->getManager();

            $data = json_decode($request->getContent(), true);
            $fictionHandler  = new FictionHandler();
            $fiction = $fictionHandler->createFiction($em, $data);

            if(isset($data['textes'])){

                if($data['textes'] !== null){
                    for ($i = 0; $i < count($data['textes']); $i++) {
                        $data['textes'][0]['fiction'] =  $fiction->getId();
                    }

                    $texteHandler = new TexteHandler();
                    $texteHandler->createTextes($em, $data['textes']);

                }
            }

            if(isset($data['evenements'])){

                if($data['evenements'] !== null){
                    for ($i = 0; $i < count($data['evenements']); $i++) {
                        $data['evenements'][$i]['fiction'] =  $fiction->getId();
                    }

                    $evenementHandler = new EvenementHandler();
                    $evenementHandler->createEvenements($em, $data['evenements']);
                }
            }

            if(isset($data['personnages'])){

                if($data['personnages'] !== null){
                    for ($i = 0; $i < count($data['personnages']); $i++) {
                        $data['personnages'][$i]['fiction'] =  $fiction->getId();
                    }
                    $data['personnages'][0]['fiction'] =  $fiction->getId();
                    $personnageHandler = new PersonnageHandler();
                    $personnageHandler->createPersonnages($em, $data['personnages'], $fiction);
                }
            }

            $response = $this->getFiction($fiction->getId());
            $fictionUrl = $this->generateUrl(
                'get_fiction', array(
                'id' => $fiction->getId()
            ));

            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Location', $fictionUrl);

            return $response;

        }

        return new JsonResponse("Echec de l'insertion", 500);

    }

    /**
     * @Rest\Put("fictions/{fictionId}", name="put_fiction")
     */
    public function putFiction(Request $request, $fictionId)
    {
        $em = $this->getDoctrine()->getManager();

        $fiction = $this->getDoctrine()
            ->getRepository(Fiction::class)
            ->findOneById($fictionId);

        if (!$fiction) {
            throw $this->createNotFoundException(sprintf(
                'Pas de fiction trouvée avec l\'id "%s"',
                $fictionId
            ));
        }

        $data = json_decode($request->getContent(), true);

        $form = $this->createForm(FictionType::class, $fiction);
        $form->submit($data);

        if($form->isSubmitted()){
            $em->persist($fiction);
            $em->flush();

            return new JsonResponse("Mise à jour de la fiction", 202);
        }

        return new JsonResponse("Echec de la mise à jour");

    }

    /**
     * @Rest\Delete("/fictions/{fictionId}",name="delete_fiction")
     */
    public function deleteAction(Request $request, $fictionId)
    {

        $em = $this->getDoctrine()->getManager();

        $fiction = $this->getDoctrine()->getRepository(Fiction::class)->findOneById($fictionId);

        if (!$fiction) {
            throw $this->createNotFoundException(sprintf(
                'Aucune fiction avec l\'id "%s" n\'a été trouvée',
                $fictionId
            ));
        }

        $em->remove($fiction);
        $em->flush();

        return new JsonResponse('Suppression de la fiction '.$fictionId.'.', 202);
    }



}