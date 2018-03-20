<?php
/**
 * Created by PhpStorm.
 * User: gaetan
 * Date: 20/03/2018
 * Time: 09:26
 */

namespace App\Controller;


class TexteController
{

    private $em;

    public function __construct()
    {
        $this->em = $this->getDoctrine()->getManager();
    }


    public function getTexte()
    {
        $fiction = $this->em->getRepository('App:Concept\Texte')->findOneById($id);

        //autorisé ?

        if (!$fiction) {
            throw $this->createNotFoundException(sprintf(
                'Aucun texte avec l\'id "%s" n\'a été trouvé',
                $id
            ));
        }

        //return texte
    }

    public function getTextesByFiction()
    {
        
    }

    public function postTexte()
    {
        //post texte for a projet

    }

    public function deleteTexte()
    {
        
    }
}