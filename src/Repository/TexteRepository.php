<?php

namespace App\Repository;

use App\Entity\Element\Texte;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class TexteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Texte::class);
    }

    public function getTextesByFiction($projetId)
    {
        $query = $this->getEntityManager()->createQuery('SELECT t FROM Texte::class t JOIN t.projets p WHERE p.id = :projetId');
        $query->setParameter('projetId', $projetId);
        $textesFiction = $query->getResult();

        return $textesFiction;
    }
}