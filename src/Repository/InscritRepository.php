<?php

namespace App\Repository;

use App\Entity\Concept\Inscrit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class InscritRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Inscrit::class);
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getInscritsQueryBuilder()
    {
        return $this->createQueryBuilder('inscrit')->orderBy('inscrit.id', 'ASC');
    }
}
