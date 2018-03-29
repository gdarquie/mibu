<?php

namespace App\Entity\Item;

use App\Entity\Modele\AbstractItem;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="personnage")
 */
class Personnage extends AbstractItem
{
    private $date_naissance;

    private $date_mort;

    private $item;

    /**
     * @return mixed
     */
    public function getDateNaissance()
    {
        return $this->date_naissance;
    }

    /**
     * @param mixed $date_naissance
     */
    public function setDateNaissance($date_naissance)
    {
        $this->date_naissance = $date_naissance;
    }

    /**
     * @return mixed
     */
    public function getDateMort()
    {
        return $this->date_mort;
    }

    /**
     * @param mixed $date_mort
     */
    public function setDateMort($date_mort)
    {
        $this->date_mort = $date_mort;
    }


}