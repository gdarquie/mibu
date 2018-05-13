<?php

namespace App\Component\Handler;

use App\Entity\Element\Texte;
use Doctrine\ORM\EntityManager;

class TexteHandler
{
    /**
     * @param EntityManager $em
     * @param $data
     * @param $fiction
     * @param $item
     * @return Texte
     */
    public function createTexte(EntityManager $em, $data, $fiction, $item)
    {
        $titre = $data['titre'];
        $description = $data['description'];
        $type = $data['type'];

        $texte = new Texte($titre, $description, $type, $fiction, $item);

        $em->persist($texte);
        $em->flush();

        return $texte;
    }

    /**
     * @param EntityManager $em
     * @param $textes
     * @param $fiction
     * @return bool
     */
    public function createTextes(EntityManager $em, $textes, $fiction, $item)
    {
        foreach ($textes as $data)
        {
            $this->createTexte($em, $data, $fiction, $item);
        }

        return true;
    }
}