<?php

namespace App\Entity\Element;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Modele\AbstractItem;

/**
 * @ORM\Entity
 * @ORM\Table(name="lieu")
 */
class Lieu extends AbstractItem
{
    /**
     * @ORM\Column(type="decimal", scale=8)
     **/
    protected $lat;

    /**
     * @ORM\Column(type="decimal", scale=8)
     **/
    protected $long;

    /**
     * @return mixed
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @param mixed $lat
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
    }

    /**
     * @return mixed
     */
    public function getLong()
    {
        return $this->long;
    }

    /**
     * @param mixed $long
     */
    public function setLong($long)
    {
        $this->long = $long;
    }
}
