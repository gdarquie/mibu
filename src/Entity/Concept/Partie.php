<?php

namespace App\Entity\Concept;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Modele\AbstractConcept;

/**
 * @ORM\Entity
 * @ORM\Table(name="partie")
 */
class Partie extends AbstractConcept
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Concept\Partie")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true)
     */
    private $parent;

    /**
     * @var integer
     */
    private $niveau;
}