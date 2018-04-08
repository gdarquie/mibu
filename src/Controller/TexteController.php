<?php

namespace App\Controller;

use App\Component\Handler\TexteHandler;
use App\Entity\Concept\Fiction;
use App\Entity\Element\Texte;
use App\Component\Hydrator\TexteHydrator;
use App\Component\Serializer\CustomSerializer;
use App\Form\TexteType;
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
        $texte = $em->getRepository(Texte::class)->findOneById($texteId);

        if (!$texte) {
            throw $this->createNotFoundException(sprintf(
                'Aucun texte avec l\'id "%s" n\'a été trouvé',
                $texteId
            ));
        }

        $texteHydrator = new TexteHydrator();
        $texteIO = $texteHydrator->createTexte($em, $texte);
        $serializer = new CustomSerializer();
        $texteIO = $serializer->serialize($texteIO);

        $response = new Response($texteIO);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Rest\Post("textes/fiction={fictionId}", name="post_texte")
     */
    public function postTexte(Request $request, $fictionId)
    {
        $data = json_decode($request->getContent(), true);

        $em = $this->getDoctrine()->getManager();
        $fiction = $em->getRepository(Fiction::class)->findOneById($fictionId);

        $handlerTexte = new TexteHandler();
        $texte = $handlerTexte->createTexte($em, $data, $fiction);

        $response = new JsonResponse('Texte sauvegardé', 201);
        $texteUrl = $this->generateUrl(
            'get_texte', array(
            'texteId' => $texte->getId()
        ));

        $response->headers->set('Location', $texteUrl);

        return $response;

    }

    /**
     * @Rest\Put("textes/{texteId}", name="put_texte")
     */
    public function putTexte(Request $request, $texteId)
    {
        $em = $this->getDoctrine()->getManager();

        $texte = $this->getDoctrine()
            ->getRepository(Texte::class)
            ->findOneById($texteId);

        if (!$texte) {
            throw $this->createNotFoundException(sprintf(
                'Pas de texte trouvé avec l\'id "%s"',
                $texteId
            ));
        }

        $data = json_decode($request->getContent(), true);

        $form = $this->createForm(TexteType::class, $texte);
        $form->submit($data);

        if($form->isSubmitted()){
            $em->persist($texte);
            $em->flush();

            return new JsonResponse("Mise à jour du texte", 200);
        }

        return new JsonResponse("Echec de la mise à jour");
    }

    /**
     * @Rest\Delete("/textes/{texteId}",name="delete_texte")
     */
    public function deleteTexte(Request $request, $texteId)
    {
        $em = $this->getDoctrine()->getManager();

        $texte = $this->getDoctrine()->getRepository(Texte::class)->findOneById($texteId);

        if (!$texte) {
            throw $this->createNotFoundException(sprintf(
                'Pas de texte trouvé avec l\'id "%s"',
                $texteId
            ));
        }

        $em->remove($texte);
        $em->flush();

        return new JsonResponse('Suppression du texte '.$texteId.'.');
    }
}