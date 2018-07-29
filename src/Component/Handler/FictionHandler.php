<?php

namespace App\Component\Handler;

use App\Component\Hydrator\FictionHydrator;
use App\Component\IO\FictionIO;
use App\Component\Serializer\CustomSerializer;
use App\Entity\Concept\Fiction;
use App\Form\FictionType;
use Doctrine\ORM\EntityManager;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Request;
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
        $fictionHydrator = new FictionHydrator();
        $fictions = $this->em->getRepository(Fiction::class)->findAll();
        $fictionsIO = [];

        $adapter = new ArrayAdapter($fictions);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage($maxPerPage);
        $pagerfanta->setCurrentPage($page);

        foreach ($pagerfanta as $fiction){
            $fictionIO = $fictionHydrator->hydrateFiction($this->em, $fiction);

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

        $fictionHydrator = new FictionHydrator();
        $fictionIO = $fictionHydrator->hydrateFiction($this->em, $fiction);

        $serializer = new CustomSerializer();

        return $serializer->serialize($fictionIO);
    }

    public function postFiction($data)
    {
        $fiction = $this->createFiction($this->em, $data);

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

        $fictionHydrator = new FictionHydrator();
        $fictionIO = $fictionHydrator->hydrateFiction($this->em, $fiction);

        $serializer = new CustomSerializer();

        return $serializer->serialize($fictionIO);
    }

    public function putFiction($data)
    {
            $fiction = $this->createFiction($this->em, $data);
            dump($fiction);die;
            $this->em->persist($data);
            $this->em->flush();
            $response = $this->getFiction($data->getId());

            $fictionUrl = $this->generateUrl(
                'get_fiction', array(
                'id' => $data->getId()
            ));

            $response->headers->set('Location', $fictionUrl);

            return $response;

    }

    public function deleteFiction()
    {
        
    }

    public function createFiction(EntityManager $em, $data)
    {
        $fiction = new Fiction();
        $fiction->setTitre($data['titre']);
        $fiction->setDescription($data['description']);
        $em->persist($fiction);
        $em->flush();

        return $fiction;
    }
}