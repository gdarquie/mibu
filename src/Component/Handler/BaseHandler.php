<?php

namespace App\Component\Handler;

use App\Component\Constant\ModelType;
use App\Component\Fetcher\BaseFetcher;
use App\Component\Fetcher\FictionFetcher;
use App\Component\Fetcher\ItemFetcher;
use App\Component\IO\Pagination\PaginatedCollectionIO;
use App\Component\Serializer\CustomSerializer;
use App\Entity\Concept\Fiction;
use App\Entity\Concept\Inscrit;
use App\Entity\Element\Evenement;
use App\Entity\Element\Lieu;
use App\Entity\Element\Partie;
use App\Entity\Element\Personnage;
use App\Entity\Element\Texte;
use Doctrine\ORM\EntityManager;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Routing\Router;

class BaseHandler
{
    protected $em;
    protected $router;

    /**
     * BaseHandler constructor.
     * @param EntityManager $em
     * @param Router $router
     */
    public function __construct(EntityManager $em, Router $router)
    {
        $this->em = $em;
        $this->router = $router;
    }

    /**
     * @param $route
     * @param array $params
     * @param $targetPage
     * @return string
     */
    public function generateUrl($route, array $params, $targetPage)
    {
        return $this->router->generate(
            $route,
            array_merge(
                $params,
                array('page' => $targetPage)
            )
        );
    }

    public function generateSimpleUrl($route, array $params)
    {
        return $this->router->generate(
            $route,
            array_merge(
                $params
            )
        );
    }

    /**
     * @param $entity
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save($entity)
    {
        $this->em->persist($entity);
        $this->em->flush();

        return true;
    }

    /**
     * @return CustomSerializer
     */
    public function getSerializer(): CustomSerializer
    {
        return new CustomSerializer();
    }

    /**
     * @return BaseFetcher
     */
    public function getEntityFetcher() {

        return new BaseFetcher($this->em);
    }

    /**
     * @param $modelType
     * @return mixed
     */
    public function getEntityHydrator($modelType)
    {
        $className = 'App\Component\Hydrator\\'.ucfirst($modelType).'Hydrator';
        return new $className();
    }

    /**
     * @param $modelType
     * @return mixed
     */
    public function getEntityTransformer($modelType)
    {
        $className = 'App\Component\Transformer\\'.ucfirst($modelType).'Transformer';
        return new $className();
    }

    /**
     * @param $fictionId
     * @return mixed
     */
    public function getFiction($fictionId)
    {
        $fictionFetcher = new FictionFetcher($this->em);

        if(!$fictionId) {
            throw new BadRequestHttpException(sprintf(
                "Il n'y a pas de fiction liée à cet élément."
            ));
        }

        return $fictionFetcher->fetchFiction($fictionId);
    }

    /**
     * @param $itemId
     * @return mixed
     */
    public function getItem($itemId)
    {
        $itemFetcher = new ItemFetcher($this->em);

        if(!$itemId) {
            throw new BadRequestHttpException(sprintf(
                "Il n'y a pas d'item liée à cet élément."
            ));
        }

        return $itemFetcher->fetchItem($itemId);
    }

    /**
     * @param $entityId
     * @param $modelType
     * @return mixed
     */
    public function getEntity($entityId, $modelType)
    {
        return $this->getEntityTransformer($modelType)->convertEntityIntoIO($this->getEntityFetcher()->fetch($entityId, $modelType));

    }

    public function getElementsCollection($request, $fictionId, $modelType)
    {
        $page = $request->query->get('page', 1);
        $maxPerPage = $request->query->get('maxPerPage', 10);

        $entitiesIO = [];
        $elements = $this->em->getRepository(Fiction::class)->getElements($fictionId, $modelType);
        $adapter = new ArrayAdapter($elements);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage($maxPerPage);
        $pagerfanta->setCurrentPage($page);

        foreach ($pagerfanta->getCurrentPageResults() as $entity){
            $entityIO = $this->getEntityTransformer($modelType)->convertEntityIntoIO($entity);

            array_push($entitiesIO, $entityIO);
        }

        $total = $pagerfanta->getNbResults();

        $collection = new PaginatedCollectionIO($entitiesIO,$total);

        if($modelType === ModelType::LIEU) {
            $routeName = 'get_'.$modelType.'x';
        }

        else {
            $routeName = 'get_'.$modelType.'s';
        }

        $collection->addLink('self', $this->generateUrl($routeName, ['fictionId' => $fictionId], $page));
        $collection->addLink('first', $this->generateUrl($routeName, ['fictionId' => $fictionId], 1));
        $collection->addLink('last', $this->generateUrl($routeName, ['fictionId' => $fictionId], $pagerfanta->getNbPages()));

        if ($pagerfanta->hasPreviousPage()) {
            $collection->addLink('previous', $this->generateUrl($routeName, ['fictionId' => $fictionId], $pagerfanta->getPreviousPage()));
        }

        if ($pagerfanta->hasNextPage()) {
            $collection->addLink('next', $this->generateUrl($routeName, ['fictionId' => $fictionId], $pagerfanta->getNextPage()));
        }

        return $collection;
    }

    /**
     * @param $data
     * @param $modelType
     * @return mixed
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function postEntity($data, $modelType)
    {
        switch ($modelType) {
            case ModelType::PERSONNAGE:
                $entity = new Personnage($data['titre'], $data['description']);
                break;
            case ModelType::PARTIE:
                $entity = new Partie($data['titre'], $data['description']);
                break;
            case ModelType::EVENEMENT:
                $entity = new Evenement();
                break;
            case ModelType::TEXTE:
                $entity = new Texte($data['titre'], $data['description'], $data['type']);
                break;
            case ModelType::LIEU:
                $entity = new Lieu();
                break;
            case ModelType::INSCRIT:
                $entity = new Inscrit();
                return $this->postConcept($data, $entity, $modelType);
            case ModelType::FICTION:
                $entity = new Fiction();
                return $this->postConcept($data, $entity, $modelType);
            default:
                throw new UnauthorizedHttpException(sprintf(
                    "Aucun modelType n'est renseigné."
                ));
        }
        return $this->changeData($data, $entity, $modelType);
    }


    /**
     * @param $entityId
     * @param $data
     * @param $modelType
     * @return mixed
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function putEntity($entityId, $data, $modelType)
    {
        return $this->changeData($data, $this->getEntityFetcher()->fetch($entityId, $modelType), $modelType);
    }

    /**
     * @param $entityId
     * @param $modelType
     * @return JsonResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function deleteEntity($entityId, $modelType)
    {
        $this->em->remove($this->getEntityFetcher()->fetch($entityId, $modelType));
        $this->em->flush();

        return new JsonResponse('Suppression de l\'entité '.$modelType.' '.$entityId.'.', 200);
    }


    /**
     * @param $data
     * @param $entity
     * @param $modelType
     * @return mixed
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function postConcept($data, $entity, $modelType)
    {
        $hydrator = $this->getEntityHydrator($modelType);
        $transformer = $this->getEntityTransformer($modelType);

        $functionName = 'hydrate'.$modelType;
        $entity = $hydrator->$functionName($entity, $data);
        $this->save($entity);

        return $transformer->convertEntityIntoIO($entity);

    }

    /**
     * @param $data
     * @param $entity
     * @param $modelType
     * @return mixed
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function changeData($data, $entity, $modelType)
    {
        $hydrator = $this->getEntityHydrator($modelType);
        $transformer = $this->getEntityTransformer($modelType);

        //devrait se faire dans l'hydrator ??? pb avec l'appel des fetchers pour getFiction
        if(!isset($data['fictionId'])){
            throw new UnauthorizedHttpException(sprintf(
                "Le champ fictionId n'est pas renseigné."
            ));
        }

        $data['fiction'] = $this->getFiction($data['fictionId']);

        if(isset($data['itemId'])){
            $data['item'] = $this->getItem($data['itemId']);
        }

        $functionName = 'hydrate'.$modelType;
        $entity = $hydrator->$functionName($entity, $data);
        $this->save($entity);

        return $transformer->convertEntityIntoIO($entity);
    }

}