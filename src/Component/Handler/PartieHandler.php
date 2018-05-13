<?php

namespace App\Component\Handler;

use App\Entity\Concept\Fiction;
use App\Entity\Element\Partie;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PartieHandler
{
    public function createPartie(EntityManager $em, $data)
    {
        if(!isset($data['titre']) && !isset($data['description'])){
            throw $this->createNotFoundException(sprintf(
                'Il manque un champ titre ou description'
            ));
        }

        if(!isset ($data['fiction'])) {
            throw new BadRequestHttpException(sprintf(
                'Aucune fiction renseignée!'
            ));
        }

        if(!$data['fiction']) {
            throw new NotFoundHttpException(sprintf(
                'Aucune fiction avec l\'id "%s" n\'a été trouvé',
                $data['fiction']
            ));
        }

        $fiction = $em->getRepository(Fiction::class)->findOneById($data['fiction']);

        $titre = $data['titre'];
        $description = $data['description'];

        $partie = new Partie($titre, $description, $fiction);
        $em->persist($partie);
        $em->flush();

        return $partie;
    }

    public function createParties(EntityManager $em, $parties)
    {
        foreach ($parties as $data)
        {
            $this->createPartie($em, $data);
        }

        return true;
    }

}