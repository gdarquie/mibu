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

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getTextesQueryBuilder()
    {
        return $this->createQueryBuilder('texte')->orderBy('texte.id', 'ASC');
    }
}
