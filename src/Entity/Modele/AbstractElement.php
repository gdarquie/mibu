<?php

namespace App\Entity\Modele;

use Doctrine\ORM\Mapping as ORM;

/**
 * Abstract base class to be extended by my entity classes with same fields
 *
 * @ORM\MappedSuperclass()
 * @ORM\HasLifecycleCallbacks
 */
abstract class AbstractElement extends AbstractConcept
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