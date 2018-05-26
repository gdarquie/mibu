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
        $query = $this->getEntityManager()->createQuery('SELECT t FROM App:Element\Texte t JOIN t.fiction f WHERE f.id = :id ORDER BY t.id');
        $query->setParameter('id', $id);
        $textes = $query->getResult();

        return $textes;
    }

    public function getPersonnagesFiction($fictionId)
    {
        $query = $this->getEntityManager()->createQuery('SELECT p FROM App:Element\Personnage p JOIN p.fiction f WHERE f.id = :fictionId');
        $query->setParameter('fictionId', $fictionId);
        $personnages = $query->getResult();

        return $personnages;
    }

    public function getEvenementsFiction($fictionId)
    {
        $query = $this->getEntityManager()->createQuery('SELECT e FROM App:Element\Evenement e JOIN e.fiction f WHERE f.id = :fictionId');
        $query->setParameter('fictionId', $fictionId);
        $evenements = $query->getResult();

        return $evenements;
    }

}
