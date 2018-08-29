<?php

namespace App\Controller;

use App\Component\Fetcher\TexteFetcher;
use App\Component\Handler\TexteHandler;
use App\Component\IO\TexteIO;
use App\Component\Transformer\TexteTransformer;
use App\Component\Serializer\CustomSerializer;
use App\Form\TexteType;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;

class TexteController extends BaseController
{

    /**
     * @Rest\Get("textes/{texteId}", name="get_texte")
     */
    public function getTexte($texteId)
    {
        $texteIO = $this->getHandler()->getTexte($texteId);
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
        $texteFetcher = new TexteFetcher($em);
        $textes = $texteFetcher->fetchTextes($fictionId);

        //hydrator
        $texteHydrator = new TexteTransformer();
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
        $data = $this->getData($request);
        $texteIO = new TexteIO();
        $form = $this->createForm(TexteType::class, $texteIO);
        $form->submit($data);

        if($form->isSubmitted()) {  //remplacer par isValidate

            $texteIO = $this->getHandler()->postTexte($data);

            return $this->createApiResponse(
                $texteIO,
                200,
                $this->createRoute('get_texte', $texteIO->getId()) //todo : replace by generateUrl()
            );
        }

        return new JsonResponse("Echec de l'insertion", 500);

    }

    /**
     * @Rest\Put("textes/{texteId}", name="put_texte")
     */
    public function putTexte(Request $request, $texteId)
    {
        $em = $this->getDoctrine()->getManager();

        $texteFetcher = new TexteFetcher($em);
        $texte = $texteFetcher->fetchTexte($texteId);

        $texteHydrator = new TexteTransformer();
        $texteIO = $texteHydrator->hydrateTexte($texte);

        $data = json_decode($request->getContent(), true);

        $form = $this->createForm(TexteType::class, $texteIO);
        $form->submit($data);

        if($form->isSubmitted()){

            $texte = $this->getHandler()->updateTexte($em, $texte, $data);

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
    public function deleteAction($texteId)
    {
        return $this->getHandler()->deleteTexte($texteId);
    }

    /**
     * @return TexteHandler
     */
    public function getHandler()
    {
        $fictionHandler = new TexteHandler($this->getDoctrine()->getManager(), $this->get('router'));
        return $fictionHandler;
    }

    /**
     * @param $id
     * @return string
     */
    public function createRoute($routeName, $id)
    {
        $url = $this->generateUrl(
            $routeName, array(
            'texteId' => $id
        ));

        return $url;
    }

}