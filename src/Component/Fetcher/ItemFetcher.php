<?php

namespace App\Component\Fetcher;

use App\Entity\Modele\AbstractItem;
use Doctrine\ORM\EntityManager;

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
            throw $this->createNotFoundException(sprintf(
                'Aucune fiction avec l\'id "%s" n\'a été trouvée',
                $itemId
            ));
        }

        return $item;
    }
}