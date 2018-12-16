<?php

namespace App\Entity\Modele;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\MappedSuperclass;
use App\Component\Id\Uuid;

/**
 * Abstract base class to be extended by my entity classes with same fields.
 *
 * @MappedSuperclass
 * @ORM\HasLifecycleCallbacks
 */
abstract class AbstractConcept
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue("AUTO")
     */
    protected $id;

    /**
     * @var datetime
     *
     * @ORM\Column(type="datetime")
     */
    protected $dateCreation;

    /**
     * @var datetime
     *
     * @ORM\Column(type="datetime")
     */
    protected $dateModification;

    /**
     * @ORM\Column(type="guid")
     */
    protected $uuid;

    /**
     * @ORM\Column(type="string")
     */
    protected $titre;

    /**
     * @ORM\Column(type="text")
     */
    protected $description;

    public function __construct()
    {
        $uuid = new Uuid();
        $this->setUuid($uuid->gen_uuid());
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return datetime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * @param datetime $dateCreation
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;
    }

    /**
     * @return datetime
     */
    public function getDateModification()
    {
        return $this->dateModification;
    }

    /**
     * @param datetime $dateModification
     */
    public function setDateModification($dateModification)
    {
        $this->dateModification = $dateModification;
    }

    /**
     * @return mixed
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @param mixed $uuid
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * @return mixed
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * @param mixed $titre
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps()
    {
        $this->setDateModification(new \DateTime('now'));

        if ($this->getDateCreation() == null) {
            $this->setDateCreation(new \DateTime('now'));
        }
    }
}
