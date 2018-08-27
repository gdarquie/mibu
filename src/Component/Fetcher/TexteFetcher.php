<?php

namespace App\Component\Fetcher;

use App\Entity\Concept\Fiction;
use App\Entity\Element\Texte;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class TexteFetcher
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function fetchTexte($texteId) {

        $texte = $this->em
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

    public function fetchTextes($fictionId) {

        $textes = $this->em->getRepository(Fiction::class)->getTextesFiction($fictionId);

        if (!$textes) {
            throw new NotFoundHttpException(sprintf(
                'Aucun texte avec l\'id "%s" n\'a été trouvé pour la fiction',
                $fictionId
            ));
        }

        return $textes;
    }

}
