<?php

namespace App\Controller;

use App\Component\Constant\ModelType;
use App\Component\Handler\PartieHandler;
use App\Component\IO\PartieIO;
use App\Component\Transformer\PartieTransformer;
use App\Component\Serializer\CustomSerializer;
use App\Entity\Element\Partie;
use App\Form\PartieType;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PartieController extends BaseController
{

    /**
     * @Rest\Get("parties/{partieId}", name="get_partie")
     */
    public function getPartie($partieId)
    {
        $partieIO = $this->getHandler()->getEntity($partieId, ModelType::PARTIE);

        return $this->createApiResponse(
            $partieIO,
            200,
            $this->getHandler()->generateSimpleUrl('get_partie', ['partieId' => $partieId])
        );
    }

//    public function getParties()
//    {
//
//    }

    /**
     * @Rest\Post("parties", name="post_partie")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function postPartie(Request $request)
    {
        $data = $this->getData($request);
        $partieIO = new PartieIO();
        $form = $this->createForm(PartieType::class, $partieIO);
        $form->submit($data);

        if($form->isSubmitted()) {  //remplacer par isValidate

            $partieIO = $this->getHandler()->postEntity($data, ModelType::PARTIE);

            return $this->createApiResponse(
                $partieIO,
                200,
                $this->getHandler()->generateSimpleUrl('get_partie', ['partieId' => $partieIO->getId()])
            );
        }

        return new JsonResponse("Echec de l'insertion", 500);
    }


    /**
     * @Rest\Put("parties/{partieId}", name="put_partie")
     */
    public function putPartie(Request $request, $partieId)
    {
        $data = $this->getData($request);
        $partieIO = $this->getHandler()->putEntity($partieId, $data, ModelType::PARTIE);

        return $this->createApiResponse(
            $partieIO,
            202,
            $this->getHandler()->generateSimpleUrl('get_partie', ['partieId' => $partieIO->getId()])
        );
    }

    /**
     * @Rest\Delete("/parties/{partieId}",name="delete_partie")
     */
    public function deletePartie($partieId)
    {
        return $this->getHandler()->deleteEntity($partieId, ModelType::PARTIE);
    }

    /**
     * @Rest\Get("parties", name="get_parties")
     */
    public function getParties()
    {
        $this->em = $this->getDoctrine()->getManager();

        $partieHydrator = new PartieTransformer();
        $parties = $this->em->getRepository(Partie::class)->findAll();
        $partiesIO = [];

        foreach ($parties as $partie){
            $partieIO = $partieHydrator->hydratePartie($partie);
            array_push($partiesIO, $partieIO);
        }
        $serializer = new CustomSerializer();
        $partiesIO = $serializer->serialize($partiesIO);

        $response = new Response($partiesIO);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

//
//    /**
//     * @Rest\Post("parties", name="post_partie")
//     *
//     * @param Request $request
//     * @return JsonResponse
//     */
//    public function postPartie(Request $request)
//    {
//        $this->em = $this->getDoctrine()->getManager();
//
//        $data = json_decode($request->getContent(), true);
//
//        $handlerPartie = new PartieHandler($this->getDoctrine()->getManager(), $this->get('router'));
//        $partie = $handlerPartie->createPartie($this->em, $data);
//        $response = new JsonResponse('Partie sauvegardée', 201);
//
//        $partieUrl = $this->generateUrl(
//            'get_partie', array(
//            'id' => $partie->getId()
//        ));
//
//        $response->headers->set('Location', $partieUrl);
//
//        return $response;
//
//    }

    /**
     * @return PartieHandler
     */
    public function getHandler()
    {
        return new PartieHandler($this->getDoctrine()->getManager(), $this->get('router'));
    }

}