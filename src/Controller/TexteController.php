<?php

namespace App\Controller;

use App\Component\Fetcher\TexteFetcher;
use App\Component\Handler\TexteHandler;
use App\Component\IO\TexteIO;
use App\Entity\Element\Texte;
use App\Component\Hydrator\TexteHydrator;
use App\Component\Serializer\CustomSerializer;
use App\Form\TexteType;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;

class TexteController extends FOSRestController
{

    /**
     * @Rest\Get("textes/{texteId}", name="get_texte")
     */
    public function getTexte($texteId)
    {
        $em = $this->getDoctrine()->getManager();

        //fetch
        $texteFetcher = new TexteFetcher();
        $texte = $texteFetcher->fetchTexte($em, $texteId);

        //hydrate
        $texteHydrator = new TexteHydrator();
        $texteIO = $texteHydrator->hydrateTexte($texte);

        //serializer
        $serializer = new CustomSerializer();
        $texteIO = $serializer->serialize($texteIO);

        $response = new Response($texteIO);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Rest\Get("textes/fiction/{fictionId}", name="get_textes")
     */
    public function getTextes($fictionId, $page = 1, $maxPerPage = 10)
    {
        $em = $this->getDoctrine()->getManager();

        //fetcher
        $texteFetcher = new TexteFetcher();
        $textes = $texteFetcher->fetchTextes($em, $fictionId);

        //hydrator
        $texteHydrator = new TexteHydrator();
        $textesIO = [];
        $adapter = new ArrayAdapter($textes);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage($maxPerPage);
        $pagerfanta->setCurrentPage($page);

        foreach ($pagerfanta as $texte){
            $texteIO = $texteHydrator->hydrateTexte($texte);

            array_push($textesIO, $texteIO);
        }

        $total = $pagerfanta->getNbResults();
        $count = count($textesIO);

        //serializer
        $serializer = new CustomSerializer();
        $textesIO = $serializer->serialize($textesIO);

        $response = new Response($textesIO);

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Rest\Post("textes", name="post_texte")
     */
    public function postTexte(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $data = json_decode($request->getContent(), true);
        $handlerTexte = new TexteHandler();
        $texte = $handlerTexte->createTexte($em, $data);

        $response = $this->getTexte($texte->getId());
        $texteUrl = $this->generateUrl(
            'get_texte', array(
            'texteId' => $texte->getId()
        ));
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Location', $texteUrl);

        return $response;

    }

    /**
     * @Rest\Put("textes/{texteId}", name="put_texte")
     */
    public function putTexte(Request $request, $texteId)
    {
        $em = $this->getDoctrine()->getManager();

        $texteFetcher = new TexteFetcher();
        $texte = $texteFetcher->fetchTexte($em, $texteId);

        $texteHydrator = new TexteHydrator();
        $texteIO = $texteHydrator->hydrateTexte($texte);

        $data = json_decode($request->getContent(), true);

        $form = $this->createForm(TexteType::class, $texteIO);
        $form->submit($data);

        if($form->isSubmitted()){ //why not valid?

            $handlerTexte = new TexteHandler();
            $texte = $handlerTexte->updateTexte($em, $texte, $data);

            $em->persist($texte);
            $em->flush();

            $response = new JsonResponse("Mise à jour du texte", 202);
            $texteUrl = $this->generateUrl(
                'get_texte', array(
                'texteId' => $texte->getId()
            ));

            $response->headers->set('Location', $texteUrl);

            return $response;

        }

        return new JsonResponse("Echec de la mise à jour");
    }

    /**
     * @Rest\Delete("/textes/{texteId}",name="delete_texte")
     */
    public function deleteTexte(Request $request, $texteId)
    {
        $em = $this->getDoctrine()->getManager();

        $texteFetcher = new TexteFetcher();
        $texte = $texteFetcher->fetchTexte($em, $texteId);

        $em->remove($texte);
        $em->flush();

        return $this->getTextes($texte->getFiction()->getId());
    }
}