<?php

namespace App\Component\Handler;

use App\Component\Hydrator\FictionHydrator;
use App\Component\Transformer\FictionTransformer;
use App\Component\Serializer\CustomSerializer;
use App\Entity\Concept\Fiction;
use Doctrine\ORM\EntityManager;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FictionHandler
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getFictions($page = 1, $maxPerPage = 10)
    {
        $fictionHydrator = new FictionTransformer($this->em);
        $fictions = $this->em->getRepository(Fiction::class)->findAll();
        $fictionsIO = [];

        $adapter = new ArrayAdapter($fictions);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage($maxPerPage);
        $pagerfanta->setCurrentPage($page);

        foreach ($pagerfanta as $fiction){
            $fictionIO = $fictionHydrator->convertEntityIntoIO($fiction);

            array_push($fictionsIO, $fictionIO);
        }

        $total = $pagerfanta->getNbResults();
        $count = count($fictionsIO);

        $serializer = new CustomSerializer();
        $fictionsIO = $serializer->serialize($fictionsIO);

        return $fictionsIO;

    }

    public function getFiction($id)
    {
        $fiction = $this->em->getRepository('App:Concept\Fiction')->findOneById($id);

        if (!$fiction) {
            throw new NotFoundHttpException(sprintf(
                'Aucune fiction avec l\'id "%s" n\'a été trouvée',
                $id
            ));
        }

        $fictionHydrator = new FictionTransformer($this->em);
        $fictionIO = $fictionHydrator->convertEntityIntoIO($fiction);

        $serializer = new CustomSerializer();

        return $serializer->serialize($fictionIO);
    }

    public function postFiction($data)
    {
        $fiction = $this->createFiction($data);

        //refacto?
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

        $fictionHydrator = new FictionTransformer($this->em);
        $fictionIO = $fictionHydrator->convertEntityIntoIO($fiction);

        $serializer = new CustomSerializer();

        return $serializer->serialize($fictionIO);
    }

    public function putFiction($fictionId, $data)
    {
        //fetch fiction and check if exists
        $fiction = $this->fetchFiction($fictionId);

        //change the data
        $hydrator = new FictionHydrator();
        $fiction = $hydrator->hydrateFiction($fiction, $data);

        //save and create IO
        $fictionIO = $this->saveFiction($fiction);

        return $fictionIO;
    }

    public function deleteFiction($fictionId)
    {
        $fiction = $this->fetchFiction($fictionId);
        $this->em->remove($fiction);
        $this->em->flush();

        return new JsonResponse('Suppression de la fiction '.$fictionId.'.', 202);
    }

    public function createFiction($data) // à revoir?
    {
        $fiction = new Fiction();
        $fiction->setTitre($data['titre']);
        $fiction->setDescription($data['description']);
        $this->em->persist($fiction);
        $this->em->flush();

        return $fiction;
    }

    public function saveFiction($fiction)
    {
        //save
        $this->em->persist($fiction);
        $this->em->flush();

        //transform into IO
        $transformer = new FictionTransformer($this->em);
        $fictionIO = $transformer->convertEntityIntoIO($fiction);

        //serialize
        $serializer = new CustomSerializer();
        $fictionIO = $serializer->serialize($fictionIO);

        return $fictionIO;
    }

    public function fetchFiction($fictionId)
    {
        //get fiction
        $fiction = $this->em->getRepository('App:Concept\Fiction')->findOneById($fictionId);

        //check if fiction exists
        if (!$fiction) {
            throw new NotFoundHttpException(sprintf(
                'Aucune fiction avec l\'id "%s" n\'a été trouvée',
                $fictionId
            ));
        }

        return $fiction;
    }

}