<?php

namespace App\Entity\Concept;

use App\Entity\Modele\AbstractConcept;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="action")
 */
class Action extends AbstractConcept
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Element\Personnage")
     * @ORM\JoinColumn(name="personnage_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $personnage;

    /**
     * @ORM\Column(type="string", length=12, nullable=true)
     */
    private $cle;

    /**
     * @var datetime $created
     *
     * @ORM\Column(type="datetime")
     */
    private $debut;

    /**
     * @var datetime $created
     *
     * @ORM\Column(type="datetime")
     */
    private $fin;

    /**
     * @return mixed
     */
    public function getPersonnage()
    {
        return $this->personnage;
    }

    /**
     * @param mixed $personnage
     */
    public function setPersonnage($personnage): void
    {
        $this->personnage = $personnage;
    }

    /**
     * @return mixed
     */
    public function getCle()
    {
        return $this->cle;
    }

    /**
     * @param mixed $cle
     */
    public function setCle($cle): void
    {
        $this->cle = $cle;
    }

    /**
     * @return datetime
     */
    public function getDebut()
    {
        return $this->debut;
    }

    /**
     * @param $debut
     */
    public function setDebut($debut): void
    {
        $this->debut = $debut;
    }

    /**
     * @return datetime
     */
    public function getFin()
    {
        return $this->fin;
    }

    /**
     * @param $fin
     */
    public function setFin($fin): void
    {
        $this->fin = $fin;
    }
}
