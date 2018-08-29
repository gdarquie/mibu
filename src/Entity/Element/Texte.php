<?php

namespace App\Entity\Element;

use App\Entity\Modele\AbstractElement;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TexteRepository")
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

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Modele\AbstractItem")
     * @ORM\JoinColumn(name="item_id", referencedColumnName="id", onDelete="CASCADE", nullable=true)
     */
    private $item;

    /**
     * Texte constructor.
     * @param $titre
     * @param $description
     * @param $type
     * @param $fiction
     * @param null $item
     */
    public function __construct($titre, $description, $type, $fiction, $item = null)
    {
        parent::__construct();
        $this->setTitre($titre);
        $this->setDescription($description);
        $this->setType($type);
        $this->setFiction($fiction);
        $this->setItem($item);
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

}