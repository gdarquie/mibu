<?php

namespace App\Component\Fetcher;

use App\Entity\Concept\Inscrit;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class InscritFetcher
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function fetchInscrit($inscritId)
    {
        $inscrit = $this->em->getRepository(Inscrit::class)->findOneById($inscritId);

        if (!$inscrit) {
            throw new NotFoundHttpException(sprintf(
                'Aucun inscrit avec l\'id "%s" n\'a été trouvé',
                $inscritId
            ));
        }

        return $inscrit;
    }
}
