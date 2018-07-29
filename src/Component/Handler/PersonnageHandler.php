<?php

namespace App\Component\Handler;

use App\Entity\Element\Personnage;
use Doctrine\ORM\EntityManager;

class PersonnageHandler
{
    /**
     * PersonnageHandler constructor.
     */
    public function __construct()
    {
        $this->helper = new HelperHandler();
    }


    /**
     * @param EntityManager $em
     * @param $data
     * @return Personnage|mixed
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createPersonnage(EntityManager $em, $data)
    {
        $data = $this->getData($em, $data);
        $personnage = $this->setData($data);

        $em->persist($personnage);
        $em->flush();

        return $personnage;
    }

    /**
     * @param EntityManager $em
     * @param $personnages
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createPersonnages(EntityManager $em, $personnages)
    {
        foreach ($personnages as $data)
        {
            $this->createPersonnage($em, $data);
        }

        return true;
    }

    /**
     * @param $em
     * @param $personnage
     * @param $data
     * @return Personnage|mixed
     */
    public function updatePersonnage($em, $personnage, $data)
    {
        $data = $this->getData($em, $data);
        $personnage = $this->setData($data, $personnage);

        $em->persist($personnage);
        $em->flush();

        return $personnage;
    }

    /**
     * @param $em
     * @param $data
     * @return mixed
     */
    public function getData($em, $data)
    {
        return $data = $this->helper->getData($em, $data);
    }

    /**
     * @param $data
     * @param Personnage|null $personnage
     * @return Personnage|mixed
     */
    public function setData($data, Personnage $personnage = null)
    {
        (!$personnage) ? $personnage = new Personnage($data['titre'],$data['description']) : $personnage = $this->helper->setData($data, $personnage);

        return $personnage = $this->setPersonnageData($personnage, $data);

    }

    /**
     * @param $personnage
     * @param $data
     * @return mixed
     */
    public function setPersonnageData($personnage, $data)
    {
        (isset($data['nom'])) ? $personnage->setNom($data['nom']) : $personnage->setNom(null);
        (isset($data['prenom'])) ? $personnage->setPrenom($data['prenom']) : $personnage->setPrenom(null);
        (isset($data['annee_naissance'])) ? $personnage->setAnneeNaissance($data['annee_naissance']) : $personnage->setAnneeNaissance(null);
        (isset($data['annee_mort'])) ? $personnage->setAnneeMort($data['annee_mort']) : $personnage->setAnneeMort(null);
        (isset($data['genre'])) ? $personnage->setGenre($data['genre']) : $personnage->setGenre(null);

        $personnage->setFiction($data['fictionId']);

        return $personnage;
    }

}