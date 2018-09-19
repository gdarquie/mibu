<?php

namespace App\Entity\Concept;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Modele\AbstractConcept;
use App\Entity\Element\Texte;
use App\Entity\Element\Personnage;

/**
 * @ORM\Entity
 * @ORM\Table(name="inscrit")
 */
class Inscrit extends AbstractConcept
{
    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $genre;


    /**
     * @ORM\Column(type="date", name="date_naissance")
     */
    private $dateNaissance;

    /**
     * @ORM\Column(type="string")
     */
    private $email;

    // ce sera le reverse d'inscrit pour fiction
    private $fictions;

    /**
     * @return string
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getPrenom(): string
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     */
    public function setPrenom(string $prenom): void
    {
        $this->prenom = $prenom;
    }

    /**
     * @return string
     */
    public function getGenre(): string
    {
        return $this->genre;
    }

    /**
     * @param string $genre
     */
    public function setGenre(string $genre): void
    {
        $this->genre = $genre;
    }

    /**
     * @return mixed
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * @param mixed $dateNaissance
     */
    public function setDateNaissance($dateNaissance): void
    {
        $this->dateNaissance = $dateNaissance;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }
}