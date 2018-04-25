<?php

namespace App\Component\IO;

class FictionIO
{

    private $id;
    private $titre;
    private $promesse;
    private $resume;
    private $textes;
    private $personnages;
    private $evenements;

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
    public function getPromesse()
    {
        return $this->promesse;
    }

    /**
     * @param mixed $promesse
     */
    public function setPromesse($promesse)
    {
        $this->promesse = $promesse;
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

}