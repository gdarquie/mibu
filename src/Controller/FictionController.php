<?php

namespace App\Controller;

use App\Component\Handler\EvenementHandler;
use App\Component\Handler\FictionHandler;

use App\Component\Handler\PersonnageHandler;
use App\Component\Handler\TexteHandler;
use App\Component\Hydrator\FictionHydrator;
use App\Component\IO\FictionIO;
use App\Entity\Concept\Fiction;
use App\Form\FictionType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FictionController extends FOSRestController
{
    /**
     * @Rest\Get("fictions", name="get_fictions")
     */
    public function getFictions(): Response
    {
        return $this->getResponse(
            $this->getHandler()->getFictions($page = 1, $maxPerPage = 10)
        );
    }

    /**
     * @Rest\Get("fictions/{id}", name="get_fiction")
     */
    public function getFiction($id): Response
    {
        return $this->getResponse(
            $this->getHandler()->getFiction($id)
        );
    }

    /**
     * @Rest\Post("fictions", name="post_fiction")
     *
     * @param Request $request
     * @return JsonResponse|Response
     */
    public function postFiction(Request $request)
    {
//        $data = $request->request->all();
        $data = json_decode($request->getContent(), true);

        $fictionIO = new FictionIO();
        $form = $this->createForm(FictionType::class, $fictionIO);
        $form->submit($data);

        if($form->isSubmitted()) {  //remplacer par isValidate

            $fictionIO = $this->getHandler()->postFiction($data);

            $url = $this->generateUrl(
                'get_fiction', array(
                'id' => json_decode($fictionIO)->id
            ));

            $response = $this->getResponse($fictionIO, $url);

            return $response;
        }

        return new JsonResponse("Echec de l'insertion", 500);
    }

    /**
     * @Rest\Put("fictions/{fictionId}", name="put_fiction")
     */
    public function putFiction(Request $request, $fictionId)
    {
        $em = $this->getDoctrine()->getManager();
        $fiction = $em->getRepository('App:Concept\Fiction')->findOneById($fictionId);

        if (!$fiction) {
            throw new NotFoundHttpException(sprintf(
                'Aucune fiction avec l\'id "%s" n\'a été trouvée',
                $fictionId
            ));
        }

        $data = json_decode($request->getContent(), true);

        $fictionIO = new FictionIO();
        $fictionIO->setId($fictionId);
        $data['id'] = $fictionId;
//        $fictionIO->setTitre($data['titre']);
//        $fictionIO->setDescription($data['description']);

        $form = $this->createForm(FictionType::class, $fictionIO);
        $form->submit($data);

        if($form->isSubmitted()){
            return $this->getHandler()->putFiction($data);
        }

        return new JsonResponse("Echec de la mise à jour");


    }

    /**
     * @Rest\Delete("/fictions/{fictionId}",name="delete_fiction")
     */
    public function deleteAction(Request $request, $fictionId)
    {

        $em = $this->getDoctrine()->getManager();

        $fiction = $this->getDoctrine()->getRepository(Fiction::class)->findOneById($fictionId);

        if (!$fiction) {
            throw $this->createNotFoundException(sprintf(
                'Aucune fiction avec l\'id "%s" n\'a été trouvée',
                $fictionId
            ));
        }

        $em->remove($fiction);
        $em->flush();

        return new JsonResponse('Suppression de la fiction '.$fictionId.'.', 202);
    }

    public function getHandler()
    {
        $fictionHandler = new FictionHandler($this->getDoctrine()->getManager());
        return $fictionHandler;
    }

    public function getResponse($io, $url = null)
    {
        $response = new Response($io);
        $response->headers->set('Content-Type', 'application/json');

        if (isset($url)) {
            $response->headers->set('Location', $url);
        }

        return $response;
    }
}