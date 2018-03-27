<?php

namespace App\Repository;

use App\Entity\Concept\Fiction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class FictionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Fiction::class);
    }

    public function getTextesFiction($id)
    {
        $query = $this->getEntityManager()->createQuery('SELECT t.id, t.uuid, t.titre, t.description FROM App:Element\Texte t JOIN t.fiction f WHERE f.id = :id ORDER BY t.id');
        $query->setParameter('id', $id);
        $textesFiction = $query->getResult();

        return $textesFiction;
    }

}
