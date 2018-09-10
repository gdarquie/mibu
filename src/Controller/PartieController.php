<?php

namespace App\Controller;

use App\Component\Handler\PartieHandler;
use App\Component\Transformer\PartieTransformer;
use App\Component\Serializer\CustomSerializer;
use App\Entity\Concept\Fiction;
use App\Entity\Element\Partie;
use App\Form\PartieType;
use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\FOSRestController;
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
        $partieIO = $this->getHandler()->getPartie($partieId);

        return $this->createApiResponse(
            $partieIO,
            200,
            $this->getHandler()->generateSimpleUrl('get_partie', ['partieId' => $partieId])
        );
    }

//    public function postPartie()
//    {
//
//    }
//

    /**
     * @Rest\Put("parties/{partieId}", name="put_partie")
     */
    public function putPartie(Request $request, $partieId)
    {
        $data = $this->getData($request);
        $partieIO = $this->getHandler()->putPartie($partieId, $data);

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
        return $this->getHandler()->deletePartie($partieId);
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


    /**
     * @Rest\Post("parties", name="post_partie")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function postPartie(Request $request)
    {
        $this->em = $this->getDoctrine()->getManager();

        $data = json_decode($request->getContent(), true);

        $handlerPartie = new PartieHandler($this->getDoctrine()->getManager(), $this->get('router'));
        $partie = $handlerPartie->createPartie($this->em, $data);
        $response = new JsonResponse('Partie sauvegardée', 201);

        $partieUrl = $this->generateUrl(
            'get_partie', array(
            'id' => $partie->getId()
        ));

        $response->headers->set('Location', $partieUrl);

        return $response;

    }

//    /**
//     * @Rest\Put("parties/{partieId}", name="put_partie")
//     */
//    public function putPartie(Request $request, $partieId)
//    {
//        $this->em = $this->getDoctrine()->getManager();
//
//        $partie = $this->getDoctrine()
//            ->getRepository(Partie::class)
//            ->findOneById($partieId);
//
//        if (!$partie) {
//            throw $this->createNotFoundException(sprintf(
//                'Pas de partie trouvée avec l\'id "%s"',
//                $partieId
//            ));
//        }
//
//        $data = json_decode($request->getContent(), true);
//
//        $form = $this->createForm(PartieType::class, $partie);
//        $form->submit($data);
//
//        if($form->isSubmitted()){
//            $this->em->persist($partie);
//            $this->em->flush();
//
//            $response = new JsonResponse("Mise à jour de la partie", 202);
//            $partieUrl = $this->generateUrl(
//                'get_partie', array(
//                'id' => $partie->getId()
//            ));
//
//            $response->headers->set('Location', $partieUrl);
//
//            return $response;
//
//        }
//
//        return new JsonResponse("Echec de la mise à jour");
//    }

    /**
     * @return PartieHandler
     */
    public function getHandler()
    {
        return new PartieHandler($this->getDoctrine()->getManager(), $this->get('router'));
    }

}