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
    private $anneeNaissance;

    /**
     * @var int
     */
    private $anneeMort;

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
        return $this->anneeNaissance;
    }

    /**
     * @param mixed $anneeNaissance
     */
    public function setAnneeNaissance($anneeNaissance)
    {
        $this->anneeNaissance = $anneeNaissance;
    }

    /**
     * @return mixed
     */
    public function getAnneeMort()
    {
        return $this->anneeMort;
    }

    /**
     * @param mixed $anneeMort
     */
    public function setAnneeMort($anneeMort)
    {
        $this->anneeMort = $anneeMort;
    }

}