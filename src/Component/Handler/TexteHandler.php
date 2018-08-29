<?php

namespace App\Component\Handler;

use App\Component\Fetcher\FictionFetcher;
use App\Component\Fetcher\ItemFetcher;
use App\Component\Fetcher\TexteFetcher;
use App\Component\Serializer\CustomSerializer;
use App\Component\Transformer\TexteTransformer;
use App\Entity\Element\Texte;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Router;


class TexteHandler extends BaseHandler
{

    public function __construct(EntityManager $em, Router $router)
    {
        parent::__construct($em, $router);
        $this->helper = new HelperHandler();
    }

    public function getTexte($id)
    {
        $texte = $this->getFetcher()->fetchTexte($id);
        $texteIO = $this->getTransformer()->convertEntityIntoIO($texte);

        return $this->getSerializer()->serialize($texteIO);
    }

    public function getTextes()
    {
        
    }

    public function postTexte($data)
    {
        $fictionFetcher = new FictionFetcher($this->em);

        if(!isset($data['fictionId'])) {
            throw new BadRequestHttpException(sprintf(
                "Il n'y a pas de fiction liée à ce texte."
            ));
        }

        $fiction = $fictionFetcher->fetchFiction($data['fictionId']);

        $texte = new Texte($data['titre'], $data['description'], $data['type'], $fiction); //todo : remplacer par un hydrator

        if (isset($data['itemId'])) {

            $itemFetcher = new ItemFetcher($this->em);
            $texte->setItem($itemFetcher->fetchItem($data['itemId']));
        }

        if(!$this->save($texte)) {
            throw new NotFoundHttpException(sprintf(
                "Le texte n'a pas été sauvegardé."
            ));
        }

        return $this->getTransformer()->convertEntityIntoIO($texte);
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

    /**
     * @return TexteFetcher
     */
    public function getFetcher(): TexteFetcher
    {
        return new TexteFetcher($this->em);
    }

    /**
     * @return TexteHydrator
     */
    public function getHydrator(): TexteHydrator
    {
        return new TexteHydrator($this->em);
    }

    /**
     * @return TexteTransformer
     */
    public function getTransformer() : TexteTransformer
    {
        return new TexteTransformer($this->em);
    }

    /**
     * @return CustomSerializer
     */
    public function getSerializer(): CustomSerializer
    {
        return new CustomSerializer();
    }



}