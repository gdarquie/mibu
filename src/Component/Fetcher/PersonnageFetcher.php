<?php

namespace App\Component\Fetcher;

use App\Entity\Element\Personnage;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class PersonnageFetcher
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function fetchPersonnage($personnageId) {

        $personnage = $this->em
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