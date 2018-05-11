<?php

namespace App\Entity\Concept;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Modele\AbstractConcept;
use App\Entity\Element\Texte;
use App\Entity\Element\Personnage;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FictionRepository")
 * @ORM\Table(name="fiction")
 */
class Fiction extends AbstractConcept
{
    /**
     * @ORM\OneToMany(targetEntity=Texte::class, mappedBy="fiction")
     */
    private $textes;

    /**
     * @ORM\OneToMany(targetEntity=Personnage::class, mappedBy="fiction")
     */
    private $personnages;

    /**
     * @return mixed
     */
    public function getTextes()
    {
        return $this->textes;
    }

    /**
     * @param mixed $textes
     */
    public function setTextes($textes)
    {
        $this->textes = $textes;
    }

    /**
     * @return mixed
     */
    public function getPersonnages()
    {
        return $this->personnages;
    }

    /**
     * @param mixed $personnages
     */
    public function setPersonnages($personnages)
    {
        $this->personnages = $personnages;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getId();
    }


}