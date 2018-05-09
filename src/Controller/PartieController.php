<?php

namespace App\Controller;

use App\Entity\Concept\Partie;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;


class PartieController extends FOSRestController
{
    public function getPartie()
    {
        return Response("Hello");
    }

    /**
     * @Rest\Post("partie", name="post_partie")
     */
    public function postPartie()
    {
        $em = $this->getDoctrine()->getManager();

        $partie = new Partie();
        $partie->setTitre('Première partie');
        $partie->setDescription('Une partie qui contient un chapitre');

        $chapitre1 = new Partie();
        $chapitre1->setTitre('Chapitre 1');
        $chapitre1->setDescription('Premier chapitre');
        $chapitre1->setParent($partie);

        $chapitre2 = new Partie();
        $chapitre2->setTitre('Chapitre 2');
        $chapitre2->setDescription('Second chapitre');
        $chapitre2->setParent($partie);

        $section = new Partie();
        $section->setTitre('Section 1');
        $section->setDescription('Section 1');
        $section->setParent($partie);

        $em->persist($partie);
        $em->persist($chapitre1);
        $em->persist($chapitre2);
        $em->persist($section);

        $em->flush();

        $result = 'Hello';

        return new JsonResponse("Mission accomplie", 200);


    }

}