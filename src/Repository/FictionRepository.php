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
        $query = $this->getEntityManager()->createQuery('SELECT t.id, t.uuid, t.titre, t.description, t.type FROM App:Element\Texte t JOIN t.fiction f WHERE f.id = :id ORDER BY t.id');
        $query->setParameter('id', $id);
        $textesFiction = $query->getResult();

        return $textesFiction;
    }

    public function getPersonnagesFiction($projetId)
    {
        $query = $this->getEntityManager()->createQuery('SELECT t FROM App:Item\Personnage t JOIN t.fiction p WHERE p.id = :projetId');
        $query->setParameter('projetId', $projetId);
        $personnages = $query->getResult();

        return $personnages;
    }

    public function getEvenementsFiction($projetId)
    {
        $query = $this->getEntityManager()->createQuery('SELECT t FROM App:Item\Evenement t JOIN t.fiction p WHERE p.id = :projetId');
        $query->setParameter('projetId', $projetId);
        $evenements = $query->getResult();

        return $evenements;
    }

}
