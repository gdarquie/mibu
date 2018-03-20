<?php

namespace App\Component\Handler;

use App\Component\IO\FictionIO;
use App\Entity\Concept\Fiction;
use Doctrine\ORM\EntityManager;

class FictionHandler
{
    public function createFiction(EntityManager $em, FictionIO $fictionIO)
    {
        $fiction = new Fiction();
        $fiction->setTitre($fictionIO->getTitre());
        $fiction->setDescription($fictionIO->getPromesse());
        $em->persist($fiction);
        $em->flush();

        //save texte avec la promesse

        $id = $fiction->getId();
        return $id;

    }
}