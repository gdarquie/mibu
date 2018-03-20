<?php

namespace App\Entity\Concept;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Modele\AbstractConcept;


/**
 * @ORM\Entity(repositoryClass="App\Repository\FictionRepository")
 * @ORM\Table(name="fiction")
 */
class Fiction extends AbstractConcept
{

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Concept\Texte", mappedBy="fiction")
     */
    private $textes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Concept\Item", mappedBy="fiction")
     */
    private $items;

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
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param mixed $items
     */
    public function setItems($items)
    {
        $this->items = $items;
    }


    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getId();
    }


}