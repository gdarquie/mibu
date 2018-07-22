<?php

namespace App\Component\Fetcher;

use App\Entity\Concept\Fiction;
use App\Entity\Element\Texte;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class TexteFetcher
{

    public function fetchTexte($em, $texteId) {

        $texte = $em
            ->getRepository(Texte::class)
            ->findOneById($texteId);

        if (!$texte) {
            throw new NotFoundHttpException(sprintf(
                'Pas de texte trouvé avec l\'id "%s"',
                $texteId
            ));
        }

        return $texte;
    }

    public function fetchTextes($em, $fictionId) {

        $textes = $em->getRepository(Fiction::class)->getTextesFiction($fictionId);

        if (!$textes) {
            throw new NotFoundHttpException(sprintf(
                'Aucun texte avec l\'id "%s" n\'a été trouvé pour la fiction',
                $fictionId
            ));
        }

        return $textes;
    }




}