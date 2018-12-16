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
    private $public = false;

    /**
     * @return bool
     */
    public function isPublic(): bool
    {
        return $this->public;
    }

    /**
     * @param bool $public
     */
    public function setPublic(bool $public): void
    {
        $this->public = $public;
    }
}
