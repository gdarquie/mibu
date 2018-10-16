<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Security("is_granted('IS_AUTHENTICATED_ANONYMOUSLY')")
 */
class AccueilController extends AbstractController
{
    /**
     * @Route("/", methods={"GET","HEAD"}, name="accueil")
     */
    public function getAccueil()
    {
        return new Response('Bienvenue');
    }

}