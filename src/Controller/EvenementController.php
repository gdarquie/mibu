<?php

namespace App\Controller;

use App\Component\Constant\ModelType;
use App\Component\Handler\EvenementHandler;
use App\Component\IO\EvenementIO;
use App\Component\Transformer\EvenementTransformer;
use App\Component\Serializer\CustomSerializer;
use App\Entity\Concept\Fiction;
use App\Form\EvenementType;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;

class EvenementController extends BaseController
{

    /**
     * @Rest\Get("evenements/{evenementId}", name="get_evenement")
     */
    public function getEvenement($evenementId)
    {
        $evenementIO = $this->getHandler()->getEntity($evenementId, ModelType::EVENEMENT);

        return $this->createApiResponse(
            $evenementIO,
            200,
            $this->getHandler()->generateSimpleUrl('get_evenement', ['evenementId' => $evenementId])
        );
    }


    /**
     * @Rest\Get("evenements/fiction/{fictionId}", name="get_evenements")
     */
    public function getEvenements($fictionId, $page = 1, $maxPerPage = 10)
    {
        $em = $this->getDoctrine()->getManager();
        $evenementHydrator = new EvenementTransformer();

        $evenements = $em->getRepository(Fiction::class)->getEvenementsFiction($fictionId);

        if (!$evenements) {
            throw $this->createNotFoundException(sprintf(
                'Il n\'y a pas d\'èvenements pour la fiction dont l\'id est "%s" ',
                $fictionId
            ));
        }

        $evenementsIO = [];

        $adapter = new ArrayAdapter($evenements);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage($maxPerPage);
        $pagerfanta->setCurrentPage($page);

        foreach ($pagerfanta as $evenement){
            $evenementIO = $evenementHydrator->hydrateEvenement($evenement);

            array_push($evenementsIO, $evenementIO);
        }

        $total = $pagerfanta->getNbResults();
        $count = count($evenementsIO);

        $serializer = new CustomSerializer();
        $evenementsIO = $serializer->serialize($evenementsIO);

        $response = new Response($evenementsIO);

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
    
    /**
     * @Rest\Post("evenements", name="post_evemement")
     *
     */
    public function postEvenement(Request $request)
    {

        $data = $this->getData($request);
        $evenementIO = new EvenementIO();
        $form = $this->createForm(EvenementType::class, $evenementIO);
        $form->submit($data);

        if($form->isSubmitted()) {  //remplacer par isValidate

            $evenementIO = $this->getHandler()->postEntity($data, ModelType::EVENEMENT);

            return $this->createApiResponse(
                $evenementIO,
                200,
                $this->getHandler()->generateSimpleUrl('get_evenement', ['evenementId' => $evenementIO->getId()])
            );
        }

        return new JsonResponse("Echec de l'insertion", 500);
    }

    /**
     * @Rest\Put("/evenements/{evenementId}",name="put_evenement")
     */
    public function putEvenement(Request $request,$evenementId)
    {
        $data = $this->getData($request);
        $evenementIO = $this->getHandler()->putEntity($evenementId, $data, modelType::EVENEMENT);

        return $this->createApiResponse(
            $evenementIO,
            202,
            $this->getHandler()->generateSimpleUrl('get_personnage', ['personnageId' => $evenementIO->getId()])
        );
    }

    /**
     * @Rest\Delete("/evenements/{evenementId}",name="delete_evenement")
     */
    public function deleteEvenement($evenementId)
    {
        return $this->getHandler()->deleteEntity($evenementId, modelType::EVENEMENT);

    }

    /**
     * @return EvenementHandler
     */
    public function getHandler()
    {
        return new EvenementHandler($this->getDoctrine()->getManager(), $this->get('router'));
    }

}