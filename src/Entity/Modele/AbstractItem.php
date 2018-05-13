<?php

namespace App\Entity\Modele;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity()
 * @ORM\Table(name="item")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"personnage" = "App\Entity\Element\Personnage", "partie" = "App\Entity\Element\Partie", "evenement" = "App\Entity\Element\Evenement"})
 */
abstract class AbstractItem extends AbstractElement
{
}
