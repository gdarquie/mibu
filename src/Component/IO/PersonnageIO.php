<?php

namespace App\Component\IO;

class PersonnageIO extends ElementIO
{
    /**
     * @var string
     */
    private $prenom;

    /**
     * @var string
     */
    private $nom;

    /**
     * @var string
     */
    private $genre;

    /**
     * @var int
     */
    private $annee_naissance;

    /**
     * @var int
     */
    private $annee_mort;

    /**
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param mixed $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * @param mixed $genre
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;
    }

    /**
     * @return mixed
     */
    public function getAnneeNaissance()
    {
        return $this->annee_naissance;
    }

    /**
     * @param mixed $annee_naissance
     */
    public function setAnneeNaissance($annee_naissance)
    {
        $this->annee_naissance = $annee_naissance;
    }

    /**
     * @return mixed
     */
    public function getAnneeMort()
    {
        return $this->annee_mort;
    }

    /**
     * @param mixed $annee_mort
     */
    public function setAnneeMort($annee_mort)
    {
        $this->annee_mort = $annee_mort;
    }

}