<?php

namespace App\Entity\Element;

use App\Entity\Modele\AbstractElement;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="projet")
 */
class Projet extends AbstractElement
{
    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", options={"default" = false})
     */
    private $publique = false;

    /**
     * @return bool
     */
    public function isPublique(): bool
    {
        return $this->publique;
    }

    /**
     * @param bool $publique
     */
    public function setPublique(bool $publique): void
    {
        $this->publique = $publique;
    }
    
}
