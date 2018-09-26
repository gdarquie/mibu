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
        $inscrit = $this->getDoctrine()
            ->getRepository(Inscrit::class)
            ->findOneBy(['id' => 19]); //récupérer dynamiquement par le biais de la request

        $token = $this->get('lexik_jwt_authentication.encoder')
            ->encode([
                'exp' => time() + 3600 // 1 hour expiration
            ]);

        return new JsonResponse(['token' => $token]);    }
}