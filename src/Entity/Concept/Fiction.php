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
     * @ORM\ManyToOne(targetEntity="App\Entity\Concept\Inscrit")
     * @ORM\JoinColumn(name="inscrit_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $inscrit;

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
     * @return mixed
     */
    public function getInscrit()
    {
        return $this->inscrit;
    }

    /**
     * @param mixed $inscrit
     */
    public function setInscrit($inscrit): void
    {
        $this->inscrit = $inscrit;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getId();
    }

}