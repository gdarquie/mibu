<?php

namespace App\Entity\Concept;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Modele\AbstractConcept;
use App\Entity\Element\Texte;
use App\Entity\Element\Personnage;
use App\Entity\Element\Evenement;
use App\Entity\Element\Lieu;

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
     * @ORM\OneToMany(targetEntity=Evenement::class, mappedBy="fiction")
     */
    private $evenements;

    /**
     * @ORM\OneToMany(targetEntity=Lieu::class, mappedBy="fiction")
     */
    private $lieux;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Concept\Inscrit")
     * @ORM\JoinColumn(name="inscrit_id", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    private $inscrit; //nullable false quand inscrits ok

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Element\Projet", mappedBy="fiction")
     */
    private $projets;

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

    /**
     * @return mixed
     */
    public function getProjets()
    {
        return $this->projets;
    }

    /**
     * @param mixed $projets
     */
    public function setProjets($projets): void
    {
        $this->projets = $projets;
    }

    /**
     * @return mixed
     */
    public function getEvenements()
    {
        return $this->evenements;
    }

    /**
     * @param mixed $evenements
     */
    public function setEvenements($evenements): void
    {
        $this->evenements = $evenements;
    }

    /**
     * @return mixed
     */
    public function getLieux()
    {
        return $this->lieux;
    }

    /**
     * @param mixed $lieux
     */
    public function setLieux($lieux): void
    {
        $this->lieux = $lieux;
    }

}
