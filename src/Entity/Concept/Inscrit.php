<?php

namespace App\Entity\Concept;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Modele\AbstractConcept;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InscritRepository")
 * @ORM\Table(name="inscrit")
 */
class Inscrit extends AbstractConcept implements UserInterface
{
    /**
     * @ORM\Column(type="string", unique=true)
     */
    private $pseudo;

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
     * @ORM\Column(type="string", nullable=true)
     */
    private $genre;

    /**
     * @ORM\Column(type="date", name="date_naissance", nullable=true)
     */
    private $dateNaissance;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\OneToMany(targetEntity=Inscrit::class, mappedBy="inscrit")
     */
    private $fictions;

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername()
    {
        return $this->pseudo;
    }

    /**
     * @return mixed
     */
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * @param mixed $pseudo
     */
    public function setPseudo($pseudo): void
    {
        $this->pseudo = $pseudo;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array

    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }
    public function setRoles(array $roles): self

    {
        $this->roles = $roles;
        return $this;
    }
    /**
     * @see UserInterface
     */
    public function getPassword()

    {
        // not needed for apps that do not check user passwords
    }
    /**
     * @see UserInterface
     */
    public function getSalt()

    {
        // not needed for apps that do not check user passwords
    }
    /**
     * @see UserInterface
     */
    public function eraseCredentials()

    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

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
     * @return null|string
     */
    public function getEmail(): ?string

    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return Inscrit
     */
    public function setEmail(string $email): self

    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFictions()
    {
        return $this->fictions;
    }

    /**
     * @param mixed $fictions
     */
    public function setFictions($fictions): void
    {
        $this->fictions = $fictions;
    }



}