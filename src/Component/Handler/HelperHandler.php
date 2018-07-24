<?php

namespace App\Component\Handler;


use App\Entity\Concept\Fiction;
use App\Entity\Modele\AbstractItem;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class HelperHandler
{

    /**
     * @param $data
     */
    public function checkElement($data)
    {
        if(!isset($data['titre']) && !isset($data['description'])){
            throw new NotFoundHttpException(sprintf(
                'Il manque un champ titre ou description'
            ));
        }
    }

    /**
     * @param $em
     * @param $data
     * @return mixed
     */
    public function checkFiction($em, $data)
    {
        if(!isset ($data['fictionId'])) {
            throw new BadRequestHttpException(sprintf(
                'Aucune fiction renseignée!'
            ));
        }

        $fiction = $em->getRepository(Fiction::class)->findOneById($data['fictionId']);

        if(!$fiction) {
            throw new NotFoundHttpException(sprintf(
                'Aucune fiction avec l\'id "%s" n\'a été trouvé',
                $data['fictionId']
            ));
        }

        return $fiction;
    }


    public function getData($em, $data)
    {
        $this->checkElement($data);

        $data['fictionId'] = $this->checkFiction($em, $data);
        $data['itemId'] = (isset($data['itemId'])) ? $em->getRepository(AbstractItem::class)->findOneById($data['itemId']) : $data['itemId'] = null ;

//        dump($data['itemId']);die; //il faut probablement créer l'item d'abord

        return $data;
    }

    public function setData($data, $element)
    {
        $element->setTitre($data['titre']);
        $element->setDescription($data['description']);
        $element->setFiction($data['fictionId']);
        $element->setItem($data['itemId']);

        (isset($data['type'])) ? $element->setType($data['type']) : null;


        return $element;
    }

    public function createItem()
    {

    }
}