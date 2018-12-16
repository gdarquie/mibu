<?php

namespace App\Repository;

use App\Entity\Concept\Action;
use App\Entity\Element\Personnage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class PersonnageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Personnage::class);
    }

    /**
     * @param $fictionId
     *
     * @return mixed
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function countPersonnages($fictionId)
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT COUNT(p) FROM '.Personnage::class.' p JOIN p.fiction f WHERE f.id = :fictionId'
        )->setParameter('fictionId', $fictionId);

        return $query->getSingleScalarResult();
    }

    /**
     * @param $fictionId
     *
     * @return mixed
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function countNbWomen($fictionId)
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT COUNT(p) FROM '.Personnage::class.' p JOIN p.fiction f WHERE f.id = :fictionId AND p.genre = :woman'
        )->setParameters(['fictionId' => $fictionId, 'woman' => 'F']);

        return $query->getSingleScalarResult();
    }

    /**
     * @param $fictionId
     *
     * @return mixed
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function countNbMen($fictionId)
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT COUNT(p) FROM '.Personnage::class.' p JOIN p.fiction f WHERE f.id = :fictionId AND p.genre = :man'
        )->setParameters(['fictionId' => $fictionId, 'man' => 'M']);

        return $query->getSingleScalarResult();
    }

    /**
     * @param $fictionId
     *
     * @return mixed
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function countAverageAge($fictionId)
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT AVG((p.anneeMort)-(p.anneeNaissance)) FROM '.Personnage::class.' p JOIN p.fiction f WHERE f.id = :fictionId'
        )->setParameter('fictionId', $fictionId);

        return $query->getSingleScalarResult();
    }

    /**
     * @param $fictionId
     *
     * @return bool
     */
    public function deleteGenerated($fictionId)
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT p FROM '.Personnage::class.' p JOIN p.fiction f WHERE f.id =:fictionId'
        )->setParameter('fictionId', $fictionId);
        $personnages = $query->getResult();

        $query = $this->getEntityManager()->createQuery(
            'DELETE FROM '.Personnage::class.' p WHERE p.id IN (:personnages) AND p.auto = TRUE'
        )->setParameter('personnages', $personnages);

        return $query->execute();
    }

    public function deleteRoutinesPersonnage($personnageId)
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT a FROM '.Action::class.' a JOIN a.personnage p WHERE p.id =:personnageId'
        )->setParameter('personnageId', $personnageId);
        $actions = $query->getResult();

        $query = $this->getEntityManager()->createQuery(
            'DELETE FROM '.Action::class.' a WHERE a.id IN (:actions)'
        )->setParameter('actions', $actions);

        return $query->execute();
    }
}
