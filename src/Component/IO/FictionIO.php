<?php

namespace App\Component\IO;

class FictionIO
{

    private $id;
    private $titre;
    private $resume;
    private $textes;
    private $personnages;
    private $evenements;
    private $uuid;

    /**
     * @var \DateTime
     */
    private $date_creation;

    /**
     * @var \DateTime
     */
    private $date_modification;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
    public function getResume()
    {
        return $this->resume;
    }

    /**
     * @param mixed $resume
     */
    public function setResume($resume)
    {
        $this->resume = $resume;
    }

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
    public function getPersonnages()
    {
        return $this->personnages;
    }

    /**
     * @param mixed $personnages
     */
    public function setPersonnages($personnages)
    {
        $this->personnages = $personnages;
    }

    /**
     * @return mixed
     */
    public function getEvenements()
    {
        return $this->evenements;
    }

    /**
     * @param mixed $evenements
     */
    public function setEvenements($evenements)
    {
        $this->evenements = $evenements;
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
    public function getDateCreation()
    {
        return $this->date_creation;
    }

    /**
     * @param mixed $date_creation
     */
    public function setDateCreation($date_creation)
    {
        $this->date_creation = $date_creation;
    }

    /**
     * @return mixed
     */
    public function getDateModification()
    {
        return $this->date_modification;
    }

    /**
     * @param mixed $date_modification
     */
    public function setDateModification($date_modification)
    {
        $this->date_modification = $date_modification;
    }

}