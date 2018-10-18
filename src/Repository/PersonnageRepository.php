<?php

namespace App\Repository;

use App\Entity\Element\Personnage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class PersonnageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Personnage::class);
    }

    public function countPersonnages($fictionId)
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT COUNT(p) FROM '.Personnage::class.' p JOIN p.fiction f WHERE f.id = :fictionId'
        )->setParameter('fictionId', $fictionId);
        return $query->getSingleScalarResult();
    }

    public function countNbWomen($fictionId){
        $query = $this->getEntityManager()->createQuery(
            'SELECT COUNT(p) FROM '.Personnage::class.' p JOIN p.fiction f WHERE f.id = :fictionId AND p.genre = :woman'
        )->setParameters(['fictionId'=> $fictionId, 'woman' => 'F']);
        return $query->getSingleScalarResult();
    }

    public function countNbMen($fictionId){
        $query = $this->getEntityManager()->createQuery(
            'SELECT COUNT(p) FROM '.Personnage::class.' p JOIN p.fiction f WHERE f.id = :fictionId AND p.genre = :man'
        )->setParameters(['fictionId'=> $fictionId, 'man' => 'H']);
        return $query->getSingleScalarResult();
    }

    public function countAverageAge($fictionId)
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT AVG((p.anneeMort)-(p.anneeNaissance)) FROM '.Personnage::class.' p JOIN p.fiction f WHERE f.id = :fictionId'
        )->setParameter('fictionId', $fictionId);
        return $query->getSingleScalarResult();
    }

}


