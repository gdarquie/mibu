<?php

namespace App\Controller;

use App\Entity\Concept\Inscrit;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Security("is_granted('IS_AUTHENTICATED_ANONYMOUSLY')")
 */
class JetonController extends BaseController
{
    /**
     * @Rest\Post("jetons", name="post_jeton")
     *
     **/
    public function postJeton(Request $request)
    {
        //récupérer autrement les valeurs de l'user?
        $data = json_decode($request->getContent(), true);

        $inscrit = $this->getDoctrine()
            ->getRepository(Inscrit::class)
            ->findOneBy(['pseudo' => $data['pseudo']]); //récupérer dynamiquement par le biais de la request

        if (!$inscrit) {
            throw $this->createNotFoundException(sprintf(
                'Aucun inscrit correspondant')
            );
        }

        $isValid = $this->get('security.password_encoder')
            ->isPasswordValid($inscrit, $data['password']);

        if (!$isValid) {
            throw new BadCredentialsException();
        }

        $token = $this->get('lexik_jwt_authentication.encoder')
            ->encode([
                'pseudo' => $inscrit->getPseudo(),
                'exp' => time() + 3600 // 1 hour expiration
            ]);

        return new JsonResponse(['token' => $token]);
    }
}