<?php

namespace App\Component\IO;

class EvenementIO
{
    private $titre;
    private $description;
    private $annee_debut;
    private $annee_fin;

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
     * @return mixed
     */
    public function getAnneeDebut()
    {
        return $this->annee_debut;
    }

    /**
     * @param mixed $annee_debut
     */
    public function setAnneeDebut($annee_debut)
    {
        $this->annee_debut = $annee_debut;
    }

    /**
     * @return mixed
     */
    public function getAnneeFin()
    {
        return $this->annee_fin;
    }

    /**
     * @param mixed $annee_fin
     */
    public function setAnneeFin($annee_fin)
    {
        $this->annee_fin = $annee_fin;
    }

}