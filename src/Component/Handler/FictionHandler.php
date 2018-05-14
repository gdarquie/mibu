<?php

namespace App\Component\Handler;

use App\Entity\Concept\Fiction;
use Doctrine\ORM\EntityManager;

class FictionHandler
{
    public function createFiction(EntityManager $em, $data)
    {
        $fiction = new Fiction();

        $fiction->setTitre($data['titre']);
        $fiction->setDescription($data['description']);
        $em->persist($fiction);
        $em->flush();

        return $fiction;
    }
}