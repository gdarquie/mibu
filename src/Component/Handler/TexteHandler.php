<?php

namespace App\Component\Handler;

use App\Entity\Element\Texte;
use App\Entity\Modele\AbstractItem;


class TexteHandler
{

    public function __construct()
    {
        $this->helper = new HelperHandler();
    }

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
        return $data = $this->helper->getData($em, $data);
    }

    /**
     * @param $data
     * @param Texte|null $texte
     * @return Texte
     */
    public function setData($data, Texte $texte = null)
    {
        if(!$texte) {
            return $texte = new Texte($data['titre'],$data['description'],$data['type'],$data['fictionId'],$data['itemId']);
        }

        return $texte = $this->helper->setData($data, $texte);

    }


}