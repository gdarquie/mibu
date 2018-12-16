<?php

namespace App\Controller;

use App\Component\Constant\ModelType;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

class ProjetController extends BaseController
{
    /**
     * @var string
     */
    public $modelType = ModelType::PROJET;

    /**
     * @Rest\Get("projets/{projetId}", name="get_projet")
     */
    public function getProjet($projetId)
    {
//        if(!$this->getHandler($this->modelType)->isProjetPublic($projetId)) {
//            $this->denyAccessUnlessGranted('ROLE_USER');
//        }
//      remplacer par un voter, la route est public par défaut, mais si le projet n'est pas public et que l'user n'est ni admin, ni auteur, il ne peut lire le texte
        return $this->getAction($projetId, $this->modelType);
    }

    /**
     * @Rest\Get("projets/fiction/{fictionId}", name="get_projets")
     */
    public function getProjets(Request $request, $fictionId)
    {
        return $this->createApiResponse(
            $this->getHandler($this->modelType)->getElementsCollection($request, $fictionId, $this->modelType),
            200,
            $this->getHandler($this->modelType)->generateUrl('get_projets', ['fictionId' => $fictionId], $request->query->get('page', 1))
        );
    }

    /**
     * @Rest\Post("projets", name="post_projet")
     */
    public function postProjet(Request $request)
    {
        return $this->postAction($request, $this->modelType);
    }

    /**
     * @Rest\Put("projets/{projetId}", name="put_projet")
     */
    public function putProjet(Request $request, $projetId)
    {
        return $this->putAction($request, $projetId, $this->modelType);
    }

    /**
     * @Rest\Delete("/projets/{projetId}",name="delete_projet")
     */
    public function deleteProjet($projetId)
    {
        return $this->deleteAction($projetId, $this->modelType);
    }
}
