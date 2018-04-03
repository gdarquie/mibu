<?php

namespace App\Component\Handler;

use App\Component\IO\TexteIO;
use App\Entity\Element\Texte;
use App\Entity\Item\Personnage;
use App\Entity\Modele\AbstractElement;
use Doctrine\ORM\EntityManager;

class PersonnageHandler extends AbstractItemHandler
{
    public function createPersonnage(EntityManager $em, $data, $fiction)
    {
        $item = $this->createItem($data, $fiction);

        $personnage = new Personnage($item);

        $em->persist($personnage);
        $em->flush();
    }

}