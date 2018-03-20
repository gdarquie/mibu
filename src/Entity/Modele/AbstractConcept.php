<?php

namespace App\Entity\Modele;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\MappedSuperclass;
use App\Component\Id\Uuid;

/**
 * Abstract base class to be extended by my entity classes with same fields
 *
 * @MappedSuperclass
 * @ORM\HasLifecycleCallbacks
 */
abstract class AbstractConcept
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue("AUTO")
     */
    protected $id;

    /**
     * @var datetime $created
     *
     * @ORM\Column(type="datetime")
     */
    protected $date_creation;

    /**
     * @var datetime $created
     *
     * @ORM\Column(type="datetime")
     */
    protected $date_modification;

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
        return $this->date_creation;
    }

    /**
     * @param datetime $date_creation
     */
    public function setDateCreation($date_creation)
    {
        $this->date_creation = $date_creation;
    }

    /**
     * @return datetime
     */
    public function getDateModification()
    {
        return $this->date_modification;
    }

    /**
     * @param datetime $date_modification
     */
    public function setDateModification($date_modification)
    {
        $this->date_modification = $date_modification;
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
     *
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