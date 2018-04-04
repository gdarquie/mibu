<?php

namespace App\Entity\Concept;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Modele\AbstractConcept;
use App\Entity\Element\Texte;
use App\Entity\Element\Item;


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
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getId();
    }


}