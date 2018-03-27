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
}