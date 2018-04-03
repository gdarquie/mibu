<?php

namespace App\Component\Handler;

use App\Component\IO\TexteIO;
use App\Entity\Element\Texte;
use App\Entity\Item\Evenement;
use App\Entity\Item\Personnage;
use App\Entity\Modele\AbstractElement;
use Doctrine\ORM\EntityManager;

class EvenementHandler extends AbstractItemHandler
{
    public function createEvenement(EntityManager $em, $data, $fiction)
    {
        $item = $this->createItem($data, $fiction);

        $evenement = new Evenement($item);

        $em->persist($evenement);
        $em->flush();
    }

}