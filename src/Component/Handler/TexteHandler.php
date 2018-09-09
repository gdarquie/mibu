<?php

namespace App\Component\Handler;

use App\Component\Constant\ModelType;
use App\Component\Fetcher\FictionFetcher;
use App\Component\Fetcher\ItemFetcher;
use App\Component\Fetcher\TexteFetcher;
use App\Component\Hydrator\TexteHydrator;
use App\Component\IO\Pagination\PaginatedCollectionIO;
use App\Component\Transformer\TexteTransformer;
use App\Entity\Element\Texte;
use Doctrine\ORM\EntityManager;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Router;


class TexteHandler extends BaseHandler
{

    /**
     * TexteHandler constructor.
     * @param EntityManager $em
     * @param Router $router
     */
    public function __construct(EntityManager $em, Router $router)
    {
        parent::__construct($em, $router);
    }

    /**
     * @param $id
     * @return bool|float|int|string
     */
    public function getTexte($id)
    {
        return $this->getEntity($id, ModelType::TEXTE);
    }

    /**
     * @param $request
     * @return PaginatedCollectionIO
     */
    public function getTextes($request, $fictionId)
    {
        $page = $request->query->get('page', 1);
        $maxPerPage = $request->query->get('maxPerPage', 10);

        $textesIO = [];
        $qb = $this->em->getRepository(Texte::class)->getTextesQueryBuilder();

        $adapter = new DoctrineORMAdapter($qb);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage($maxPerPage);
        $pagerfanta->setCurrentPage($page);

        foreach ($pagerfanta->getCurrentPageResults() as $texte){
            $texteIO = $this->getTransformer()->convertEntityIntoIO($texte);

            array_push($textesIO, $texteIO);
        }

        $total = $pagerfanta->getNbResults();

        $collection = new PaginatedCollectionIO($textesIO,$total);

        $collection->addLink('self', $this->generateUrl('get_textes', ['fictionId' => $fictionId], $page));
        $collection->addLink('first', $this->generateUrl('get_textes', ['fictionId' => $fictionId], 1));
        $collection->addLink('last', $this->generateUrl('get_textes', ['fictionId' => $fictionId], $pagerfanta->getNbPages()));

        if ($pagerfanta->hasPreviousPage()) {
            $collection->addLink('previous', $this->generateUrl('get_textes', ['fictionId' => $fictionId], $pagerfanta->getPreviousPage()));
        }

        if ($pagerfanta->hasNextPage()) {
            $collection->addLink('next', $this->generateUrl('get_textes', ['fictionId' => $fictionId], $pagerfanta->getNextPage()));
        }

        return $collection;
    }

    /**
     * @param $data
     * @return \App\Component\IO\TexteIO|mixed
     */
    public function postTexte($data)
    {
        $fictionFetcher = new FictionFetcher($this->em);

        if(!isset($data['fictionId'])) {
            throw new BadRequestHttpException(sprintf(
                "Il n'y a pas de fiction liée à ce texte."
            ));
        }

        $fiction = $fictionFetcher->fetchFiction($data['fictionId']);

        $item = null;

        if (isset($data['itemId'])) {
            $itemFetcher = new ItemFetcher($this->em);
            $item = $itemFetcher->fetchItem($data['itemId']);
        }

        $texte = new Texte($data['titre'], $data['description'], $data['type'], $fiction, $item);

        if(!$this->save($texte)) {
            throw new NotFoundHttpException(sprintf(
                "Le texte n'a pas été sauvegardé."
            ));
        }

        return $this->getTransformer()->convertEntityIntoIO($texte);
    }
    
    public function putTexte($texteId, $data)
    {
        return $this->putEntity($texteId, $data, ModelType::TEXTE);
    }


    /**
     * @param $texteId
     * @return JsonResponse
     */
    public function deleteTexte($texteId)
    {
        return $this->deleteEntity($texteId, ModelType::TEXTE);
    }

    /**
     * @param $textes
     * @return bool
     */
    public function createTextes($textes)
    {
        foreach ($textes as $data)
        {
            $this->postTexte($data);
        }

        return true;
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
        return new TexteHydrator();
    }

    /**
     * @return TexteTransformer
     */
    public function getTransformer() : TexteTransformer
    {
        return new TexteTransformer();
    }

}