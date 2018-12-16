<?php

namespace App\Component\IO;

class FictionIO extends AbstractConceptIO
{
    private $textes;
    private $personnages;
    private $evenements;

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
