<?php

namespace App\Component\Fetcher;


use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

//todo : à reprendre
class IndexFetcher
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function fetch($id, $type)
    {
        //selon le type appeler le bon repo
        $index = $this->em->getRepository('App:Concept\Fiction')->findOneById($id);

        if (!$index) {
            throw new NotFoundHttpException(sprintf(
                'Aucun objet avec l\'id "%s" n\'a été trouvé',
                $id
            ));
        }

        return $index;
    }

}