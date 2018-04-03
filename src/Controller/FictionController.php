<?php

namespace App\Controller;

use App\Component\Handler\FictionHandler;
use App\Component\Handler\AbstractItemHandler;
use App\Component\Hydrator\FictionHydrator;
use App\Component\Serializer\CustomSerializer;
use App\Entity\Concept\Fiction;
use App\Form\FictionType;
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
    public function getFictions()
    {
        $em = $this->getDoctrine()->getManager();
        $fictionHydrator = new FictionHydrator();
        $fictions = $em->getRepository(Fiction::class)->findAll();
        $fictionsIO = [];

        foreach ($fictions as $fiction){
            $fictionIO = $fictionHydrator->createFiction($em, $fiction);
            array_push($fictionsIO, $fictionIO);
        }
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
        $fictionIO = $fictionHydrator->createFiction($em, $fiction);
        $serializer = new CustomSerializer();
        $fictionIO = $serializer->serialize($fictionIO);

        $response = new Response($fictionIO);
        $response->headers->set('Content-Type', 'application/json');

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

            $fictionHandler  = new FictionHandler();
            $fiction = $fictionHandler->createFiction($em, $data);

            $texteHandler = new AbstractItemHandler();
            if($texteHandler->createTextes($em, $data['textes'], $fiction) !== true){
                return new JsonResponse('Echec de la sauvegarde des textes');
            };

            $response = new JsonResponse('Projet sauvegardé', 201);
            $fictionUrl = $this->generateUrl(
                'get_fiction', array(
                'id' => $fiction->getId()
            ));

            $response->headers->set('Location', $fictionUrl);

            return $response;
        }

        return new JsonResponse("Echec de l'insertion");

    }

    /**
     * @Rest\Post("fictions/{id}", name="put_fiction")
     */
    public function putFiction(Request $request)
    {
        $data = json_decode($request->getContent(), true);
//        $form = $this->createForm(FictionType::class, $fiction);
//        $form->submit($data);

//        if($form->isSubmitted()){
//            //vérifier que le texte existe bien
//        }

        //récupérer la fiction et save

        return new JsonResponse("Echec de la mise à jour");

    }

    /**
     * @Rest\GET("delete/fictions/{id}", name="delete_fiction")
     */
    public function deleteAction(Request $request, Fiction $fiction)
    {
        $form = $this->createDeleteForm($fiction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($fiction);
            dump($fiction);die;
            $em->flush();
        }

        return $this->redirectToRoute('get_fictions');
    }

    /**
     *
     * @param Fiction $fiction
     *
     * @return \Symfony\Component\Form\Form
     */
    private function createDeleteForm(Fiction $fiction)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('delete_fiction', array('id' => $fiction->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }


}