<?php

namespace App\Component\Handler;


use App\Entity\Concept\Fiction;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class HelperHandler
{

    public function checkElement($data)
    {
        if(!isset($data['titre']) && !isset($data['description'])){
            throw new NotFoundHttpException(sprintf(
                'Il manque un champ titre ou description'
            ));
        }
    }
    public function checkFiction($em, $data)
    {

        if(!isset ($data['fiction'])) {
            throw new BadRequestHttpException(sprintf(
                'Aucune fiction renseignée!'
            ));
        }

        $fiction = $em->getRepository(Fiction::class)->findOneById($data['fiction']);

        if(!$fiction) {
            throw new NotFoundHttpException(sprintf(
                'Aucune fiction avec l\'id "%s" n\'a été trouvé',
                $data['fiction']
            ));
        }

        return $fiction;
    }
}