<?php

namespace App\Entity\Element;

use App\Entity\Modele\AbstractItem;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="evenement")
 */
class Evenement extends AbstractItem
{
    /**
     * @ORM\Column(type="integer")
     */
    private $annee_debut;

    /**
     * @ORM\Column(type="integer")
     */
    private $annee_fin;

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
