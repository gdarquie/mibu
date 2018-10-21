<?php

namespace App\Component\Fetcher;

use App\Component\Constant\ModelType;
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
            case ModelType::FICTION:
                $entityName = 'App\Entity\Concept\Fiction';
                break;
            case ModelType::INSCRIT:
                $entityName = 'App\Entity\Concept\Inscrit';
                break;
            default:
                $entityName = 'App\Entity\Element\\'.ucfirst($modelType);
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