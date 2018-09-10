<?php

namespace App\Component\Fetcher;

use App\Entity\Concept\Fiction;
use App\Entity\Element\Evenement;
use App\Entity\Element\Texte;
use App\Entity\Element\Partie;
use App\Entity\Element\Personnage;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BaseFetcher
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function fetch($id, $modelType)
    {
        switch ($modelType) {
            case 'Fiction':
                $entityName = 'App\Entity\Concept\Fiction';
                break;
            default:
                $entityName = 'App\Entity\Element\\'.ucfirst($modelType);
//                $entityName = Texte::class;
                break;
        }

        $entity = $this->em->getRepository($entityName)->findOneById($id);

        if (!$entity) {
            throw new NotFoundHttpException(sprintf(
                'Aucune entité '.ucfirst($modelType).' avec l\'id %s n\'a été trouvée',
                $id
            ));
        }

        return $entity;
    }
}