<?php

namespace App\Component\Handler;

use App\Component\Fetcher\FictionFetcher;
use App\Component\Hydrator\FictionHydrator;
use App\Component\IO\Pagination\PaginatedCollectionIO;
use App\Component\Transformer\FictionTransformer;
use App\Component\Serializer\CustomSerializer;
use App\Entity\Concept\Fiction;
use Doctrine\ORM\EntityManager;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Router;


class FictionHandler extends BaseHandler
{
    public function __construct(EntityManager $em, Router $router)
    {
        parent::__construct($em, $router);
    }

    /**
     * @param $request
     * @return PaginatedCollectionIO
     */
    public function getFictions($request)
    {
        $page = $request->query->get('page', 1);
        $maxPerPage = $request->query->get('maxPerPage', 10);

        $fictionsIO = [];
        $qb = $this->em->getRepository(Fiction::class)->getTextesQueryBuilder();

        $adapter = new DoctrineORMAdapter($qb);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage($maxPerPage);
        $pagerfanta->setCurrentPage($page);

        foreach ($pagerfanta->getCurrentPageResults() as $fiction){
            $fictionIO = $this->getTransformer()->convertEntityIntoIO($fiction);

            array_push($fictionsIO, $fictionIO);
        }

        $total = $pagerfanta->getNbResults();

        $collection = new PaginatedCollectionIO($fictionsIO,$total);

        $collection->addLink('self', $this->generateUrl('get_fictions', [], $page));
        $collection->addLink('first', $this->generateUrl('get_fictions', [], 1));
        $collection->addLink('last', $this->generateUrl('get_fictions', [], $pagerfanta->getNbPages()));

        if ($pagerfanta->hasPreviousPage()) {
            $collection->addLink('previous', $this->generateUrl('get_fictions', [], $pagerfanta->getPreviousPage()));
        }

        if ($pagerfanta->hasNextPage()) {
            $collection->addLink('next', $this->generateUrl('get_fictions', [], $pagerfanta->getNextPage()));
        }

        return $collection;

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
        $fiction = new Fiction();
        $fiction = $this->getHydrator()->hydrateFiction($fiction, $data);

        //add a check for testing if valid? (add a form)
        $fictionIO = $this->saveFiction($fiction);

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

        //change into Json
        $fictionIO = $this->getSerializer()->serialize($fictionIO);

        return $fictionIO;
    }

    public function deleteFiction($fictionId)
    {
        $fiction = $this->getFetcher()->fetchFiction($fictionId);
        $this->em->remove($fiction);
        $this->em->flush();

        return new JsonResponse('Suppression de la fiction '.$fictionId.'.', 202);
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
        $this->save($fiction);

        //transform into IO
        $transformer = new FictionTransformer($this->em);
        $fictionIO = $transformer->convertEntityIntoIO($fiction);

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