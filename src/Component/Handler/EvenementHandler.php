<?php

namespace App\Component\Handler;

use App\Entity\Concept\Fiction;
use App\Entity\Element\Evenement;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EvenementHandler
{
    public function createEvenement(EntityManager $em, $data)
    {
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

        $evenement = new Evenement();

        $evenement->setTitre($data['titre']);
        $evenement->setDescription($data['description']);
        $evenement->setAnneeDebut($data['annee_debut']);
        $evenement->setAnneeFin($data['annee_fin']);
        $evenement->setFiction($fiction);

        $em->persist($evenement);
        $em->flush();

        return $evenement;
    }

    public function createEvenements(EntityManager $em, $evenements)
    {
        foreach ($evenements as $data)
        {
            $this->createEvenement($em, $data, $fiction);
        }

        return true;
    }

}