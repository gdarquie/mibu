<?php

namespace App\Component\Handler;

use App\Component\Fetcher\FictionFetcher;
use App\Component\Hydrator\FictionHydrator;
use App\Component\Transformer\FictionTransformer;
use App\Component\Serializer\CustomSerializer;
use App\Entity\Concept\Fiction;
use Doctrine\ORM\EntityManager;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\JsonResponse;

class FictionHandler
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param int $page
     * @param int $maxPerPage
     * @return array|bool|float|int|string
     */
    public function getFictions($page = 1, $maxPerPage = 10)
    {
        $fictions = $this->em->getRepository(Fiction::class)->findAll();
        $fictionsIO = [];

        $adapter = new ArrayAdapter($fictions);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage($maxPerPage);
        $pagerfanta->setCurrentPage($page);

        foreach ($pagerfanta as $fiction){
            $fictionIO = $this-$this->getTransformer()->convertEntityIntoIO($fiction);

            array_push($fictionsIO, $fictionIO);
        }

        $total = $pagerfanta->getNbResults();
        $count = count($fictionsIO);

        $serializer = new CustomSerializer();
        $fictionsIO = $serializer->serialize($fictionsIO);

        return $fictionsIO;

    }

    /**
     * @param $id
     * @return bool|float|int|string
     */
    public function getFiction($id)
    {
        $fiction = $this->getFetcher()->fetchFiction($id);
        $fictionIO = $this->getTransformer()->convertEntityIntoIO($fiction);

        return $this->getSerializer()->serialize($fictionIO);
    }

    /**
     * @param $data
     * @return bool|float|int|string
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function postFiction($data)
    {
        $fiction = $this->createFiction($data);

        //todo = refacto en une seule fonction
        if(isset($data['textes'])){

            if($data['textes'] !== null){
                for ($i = 0; $i < count($data['textes']); $i++) {
                    $data['textes'][0]['fictionId'] =  $fiction->getId();
                }

                $texteHandler = new TexteHandler();
                $texteHandler->createTextes($this->em, $data['textes']);

            }
        }

        if(isset($data['evenements'])){

            if($data['evenements'] !== null){
                for ($i = 0; $i < count($data['evenements']); $i++) {
                    $data['evenements'][$i]['fiction'] =  $fiction->getId();
                }

                $evenementHandler = new EvenementHandler();
                $evenementHandler->createEvenements($this->em, $data['evenements']);
            }
        }

        if(isset($data['personnages'])){

            if($data['personnages'] !== null){
                for ($i = 0; $i < count($data['personnages']); $i++) {
                    $data['personnages'][$i]['fiction'] =  $fiction->getId();
                }
                $data['personnages'][0]['fiction'] =  $fiction->getId();
                $personnageHandler = new PersonnageHandler();
                $personnageHandler->createPersonnages($this->em, $data['personnages']);
            }
        }

        $fictionIO = $this->getTransformer()->convertEntityIntoIO($fiction);

        return $this->getSerializer()->serialize($fictionIO);
    }


    /**
     * @param $fictionId
     * @param $data
     * @return \App\Component\IO\FictionIO|bool|float|int|string
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function putFiction($fictionId, $data)
    {
        //fetch fiction and check if exists
        $fiction = $this->getFetcher()->fetchFiction($fictionId);

        //change the data
        $fiction = $this->getHydrator()->hydrateFiction($fiction, $data);

        //save and create IO
        $fictionIO = $this->saveFiction($fiction);

        return $fictionIO;
    }

    public function deleteFiction($fictionId)
    {
        $fiction = $this->getFetcher()->fetchFiction($fictionId);
        $this->em->remove($fiction);
        $this->em->flush();

        return new JsonResponse('Suppression de la fiction '.$fictionId.'.', 202);
    }

    // todo : à revoir?
    public function createFiction($data)
    {
        $fiction = new Fiction();
        $fiction->setTitre($data['titre']);
        $fiction->setDescription($data['description']);
        $this->em->persist($fiction);
        $this->em->flush();

        return $fiction;
    }

    /**
     * @param $fiction
     * @return \App\Component\IO\FictionIO|bool|float|int|string
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function saveFiction($fiction)
    {
        //save
        $this->em->persist($fiction);
        $this->em->flush();

        //transform into IO
        $transformer = new FictionTransformer($this->em);
        $fictionIO = $transformer->convertEntityIntoIO($fiction);

        //serialize
        $fictionIO = $this->getSerializer()->serialize($fictionIO);

        return $fictionIO;
    }

    /**
     * @return FictionHydrator
     */
    public function getHydrator(): FictionHydrator
    {
        return new FictionHydrator();
    }

    /**
     * @return CustomSerializer
     */
    public function getSerializer(): CustomSerializer
    {
        return new CustomSerializer();
    }

    /**
     * @return FictionTransformer
     */
    public function getTransformer(): FictionTransformer
    {
        return new FictionTransformer($this->em);
    }

    /**
     * @return FictionFetcher
     */
    public function getFetcher()
    {
        return new FictionFetcher($this->em);
    }

}