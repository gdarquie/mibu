<?php

namespace App\Entity\Concept;

use App\Entity\Modele\AbstractConcept;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TexteRepository")
 * @ORM\Table(name="texte")
 */
class Texte extends AbstractConcept
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Concept\Fiction")
     * @ORM\JoinColumn(name="fiction_id", referencedColumnName="id")
     */
    private $fiction;

    /**
     * @return mixed
     */
    public function getFiction()
    {
        return $this->fiction;
    }

    /**
     * @param mixed $fiction
     */
    public function setFiction($fiction)
    {
        $this->fiction = $fiction;
    }


}