<?php

namespace App\Component\Handler;

use App\Component\Fetcher\TexteFetcher;
use App\Entity\Element\Texte;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Router;


class TexteHandler extends BaseHandler
{

    public function __construct(EntityManager $em, Router $router)
    {
        parent::__construct($em, $router);
        $this->helper = new HelperHandler();
    }

    public function getTexte()
    {
        
    }

    public function getTextes()
    {
        
    }
    
    public function putTexte()
    {
        
    }
    
    public function deleteTexte($texteId)
    {
        $texte = $this->getFetcher()->fetchTexte($texteId);
        $this->em->remove($texte);
        $this->em->flush();

        return new JsonResponse('Suppression du texte '.$texteId.'.', 200);
    }

    //todo : delete ?
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

    public function getFetcher()
    {
        return new TexteFetcher($this->em);
    }


}