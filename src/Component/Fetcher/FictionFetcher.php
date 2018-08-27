<?php

namespace App\Component\Fetcher;

use App\Entity\Concept\Fiction;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FictionFetcher
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }


    public function fetchFiction($fictionId)
    {
        $fiction = $this->em->getRepository(Fiction::class)->findOneById($fictionId);

        if (!$fiction) {
            throw new NotFoundHttpException(sprintf(
                'Aucune fiction avec l\'id "%s" n\'a été trouvée',
                $fictionId
            ));
        }

        return $fiction;
    }

}