<?php

namespace App\Controller;

use App\Entity\Concept\Inscrit;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class JetonController extends BaseController
{
    /**
     * @Rest\Post("jetons", name="post_jeton")
     *
     **/
    public function postJeton(Request $request)
    {

        $data = json_decode($request->getContent(), true);

        $inscrit = $this->getDoctrine()
            ->getRepository(Inscrit::class)
            ->findOneBy(['pseudo' => $data['pseudo']]); //récupérer dynamiquement par le biais de la request

        if (!$inscrit) {
            throw $this->createNotFoundException();
        }

        $token = $this->get('lexik_jwt_authentication.encoder')
            ->encode([
                'username' => $inscrit->getPseudo(),
                'exp' => time() + 3600 // 1 hour expiration
            ]);

        return new JsonResponse(['token' => $token]);
    }
}