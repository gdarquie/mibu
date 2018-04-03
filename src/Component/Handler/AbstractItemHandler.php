<?php

namespace App\Component\Handler;

use App\Entity\Element\Item;

abstract class AbstractItemHandler
{
    public function createItem($data, $fiction)
    {
        $titre = $data['titre'];
        $description = $data['description'];
        $discriminateur = $data['descriminateur'];

        $item = new Item($titre, $description, $fiction, $discriminateur);

        return $item;

    }

//    public function createTextes(EntityManager $em, $textes, $fiction)
//    {
//        foreach ($textes as $data)
//        {
//            $this->createTexte($em, $data, $fiction);
//        }
//
//        return true;
//    }
}