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
        $data = $this->getData($em, $data);
        $texte = $this->setData($data);

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

    /**
     * @param $em
     * @param $texte
     * @param $data
     * @return Texte|null
     */
    public function updateTexte($em, $texte, $data)
    {
        $data = $this->getData($em, $data);
        $texte = $this->setData($data, $texte);

        $em->persist($texte);
        $em->flush();

        return $texte;
    }

    /**
     * @param $em
     * @param $data
     * @return mixed
     */
    public function getData($em, $data)
    {
        $helper = new HelperHandler($data);
        $helper->checkElement($data);
        $data['fiction'] = $helper->checkFiction($em, $data);
        $data['itemId'] = (isset($data['itemId'])) ? $em->getRepository(AbstractItem::class)->findOneById($data['itemId']) : $data['itemId'] = null ;

        return $data;
    }

    /**
     * @param $data
     * @param null $texte
     * @return Texte|null
     */
    public function setData($data, $texte = null)
    {
        if(!$texte) {
            return $texte = new Texte($data['titre'],$data['description'],$data['type'],$data['fiction'],$data['itemId']);
        }

        $texte->setTitre($data['titre']);
        $texte->setDescription($data['description']);
        $texte->setType($data['type']);
        $texte->setFiction($data['fiction']);
        $texte->setItem($data['itemId']);

        return $texte;
    }


}