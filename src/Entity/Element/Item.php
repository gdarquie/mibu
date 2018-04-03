<?php

namespace App\Entity\Element;

use App\Entity\Modele\AbstractItem;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="item")
 */
class Item extends AbstractItem
{
    CONST PERSONNAGE = 'personnage';
    CONST EVENEMENT = 'evenement';

    private $discriminateur;

    public function __construct($titre, $description, $fiction, $discriminateur)
    {
        parent::__construct();
        $this->setTitre($titre);
        $this->setDescription($description);
        $this->setFiction($fiction);
        $this->setDiscriminateur($discriminateur);
    }

    /**
     * @return mixed
     */
    public function getDiscriminateur()
    {
        return $this->discriminateur;
    }

    /**
     * @param mixed $discriminateur
     */
    public function setDiscriminateur($discriminateur)
    {
        $this->discriminateur = $discriminateur;
    }



}