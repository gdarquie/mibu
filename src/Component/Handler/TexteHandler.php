<?php

namespace App\Component\Handler;

use App\Entity\Element\Texte;
use App\Entity\Modele\AbstractItem;


class TexteHandler
{
    /**
     * @param $em
     * @param $data
     * @return Texte
     */
    public function createTexte($em, $data)
    {
        $helper = new HelperHandler($data);
        $helper->checkElement($data);
        $fiction = $helper->checkFiction($em, $data);

        $titre = $data['titre'];
        $description = $data['description'];
        $type = $data['type'];
        $item = (isset($data['item'])) ? $em->getRepository(AbstractItem::class)->findOneById($data['item']) : $data['item'] = null ;
        $texte = new Texte($titre, $description, $type, $fiction, $item);

        $em->persist($texte);
        $em->flush();

        return $texte;
    }

    /**
     * @param $em
     * @param $textes
     * @return bool
     */
    public function createTextes($em, $textes)
    {
        foreach ($textes as $data)
        {
            $this->createTexte($em, $data);
        }

        return true;
    }
}