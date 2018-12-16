<?php

namespace App\Entity\Element;

use App\Entity\Modele\AbstractItem;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PersonnageRepository")
 * @ORM\Table(name="personnage")
 */
class Personnage extends AbstractItem
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $anneeNaissance;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $anneeMort;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $genre;

    /**
     * @var bool
     *           généré automatiquement ?
     *
     * @ORM\Column(type="boolean")
     */
    private $auto = false;

    public function __construct($titre, $description, $item = null)
    {
        parent::__construct();
        $this->setTitre($titre);
        $this->setDescription($description);
        $this->setItem($item);
    }

    public function __clone()
    {
    }

    /**
     * @return int
     */
    public function getAnneeNaissance()
    {
        return $this->anneeNaissance;
    }

    /**
     * @param int $anneeNaissance
     */
    public function setAnneeNaissance($anneeNaissance)
    {
        $this->anneeNaissance = $anneeNaissance;
    }

    /**
     * @return int
     */
    public function getAnneeMort()
    {
        return $this->anneeMort;
    }

    /**
     * @param int $anneeMort
     */
    public function setAnneeMort($anneeMort)
    {
        $this->anneeMort = $anneeMort;
    }

    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * @return string
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * @param string $genre
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;
    }

    /**
     * @return mixed
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * @param mixed $item
     */
    public function setItem($item)
    {
        $this->item = $item;
    }

    /**
     * @return bool
     */
    public function isAuto(): bool
    {
        return $this->auto;
    }

    /**
     * @param bool $auto
     */
    public function setAuto(bool $auto): void
    {
        $this->auto = $auto;
    }
}
