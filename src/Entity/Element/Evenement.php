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
     * @ORM\Column(type="integer", nullable=true)
     */
    private $anneeDebut;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $anneeFin;

    /**
     * @return mixed
     */
    public function getAnneeDebut()
    {
        return $this->anneeDebut;
    }

    /**
     * @param mixed $anneeDebut
     */
    public function setAnneeDebut($anneeDebut)
    {
        $this->anneeDebut = $anneeDebut;
    }

    /**
     * @return mixed
     */
    public function getAnneeFin()
    {
        return $this->anneeFin;
    }

    /**
     * @param mixed $anneeFin
     */
    public function setAnneeFin($anneeFin)
    {
        $this->anneeFin = $anneeFin;
    }

}
