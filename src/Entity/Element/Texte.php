<?php

namespace App\Entity\Element;

use App\Entity\Modele\AbstractElement;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="texte")
 */
class Texte extends AbstractElement
{
    CONST TYPE_FRAGMENT = 'fragment';
    CONST TYPE_PROMESSE = 'promesse';
    CONST TYPE_PERSONNAGE = 'personnage';
    CONST TYPE_EVENEMENT = 'evenement';

    /**
     * @ORM\Column(type="string")
     */
    private $type;

    public function __construct($titre, $description, $type, $fiction)
    {
        parent::__construct();
        $this->setTitre($titre);
        $this->setDescription($description);
        $this->setType($type);
        $this->setFiction($fiction);
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }



}