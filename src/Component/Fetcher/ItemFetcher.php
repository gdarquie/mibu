<?php

namespace App\Component\Fetcher;

use App\Entity\Modele\AbstractItem;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ItemFetcher
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }


    public function fetchItem($itemId)
    {
        $item = $this->em->getRepository(AbstractItem::class)->findOneById($itemId);

        if (!$item) {
            throw new NotFoundHttpException(sprintf(
                'Aucune fiction avec l\'id "%s" n\'a été trouvée',
                $itemId
            ));
        }

        return $item;
    }
}