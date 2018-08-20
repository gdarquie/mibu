<?php

namespace App\Component\Fetcher;

use App\Entity\Concept\Fiction;
use App\Entity\Element\Personnage;
use App\Entity\Element\Texte;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class PersonnageFetcher
{
    public function fetchPersonnage($em, $personnageId) {

        $personnage = $em
            ->getRepository(Personnage::class)
            ->findOneById($personnageId);

        if (!$personnage) {
            throw new NotFoundHttpException(sprintf(
                'Pas de personnage trouvé avec l\'id "%s"',
                $personnageId
            ));
        }

        return $personnage;
    }

}