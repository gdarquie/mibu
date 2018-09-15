<?php

namespace App\Component\Handler;

use App\Component\Constant\ModelType;
use App\Component\Fetcher\TexteFetcher;
use App\Component\Hydrator\TexteHydrator;
use App\Component\IO\Pagination\PaginatedCollectionIO;
use App\Component\Transformer\TexteTransformer;
use App\Entity\Concept\Fiction;
use App\Entity\Element\Texte;
use Doctrine\ORM\EntityManager;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
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
     * @param $textes
     * @return bool
     */
    public function createTextes($textes)
    {
        foreach ($textes as $data)
        {
            $this->postEntity($data, modelType::TEXTE);
        }

        return true;
    }
}