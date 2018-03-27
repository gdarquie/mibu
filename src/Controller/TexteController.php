<?php

namespace App\Controller;

use App\Entity\Element\Texte;
use App\Component\Hydrator\TexteHydrator;
use App\Component\Serializer\CustomSerializer;
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

    public function postTexte()
    {
        //post texte for a projet

    }

    public function putTexte()
    {
        //modifier un texte existant
    }

    public function deleteTexte()
    {
        
    }
}