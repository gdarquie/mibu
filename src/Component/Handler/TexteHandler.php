<?php

namespace App\Component\Handler;

use App\Entity\Concept\Fiction;
use App\Entity\Element\Texte;
use App\Entity\Modele\AbstractItem;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;


class TexteHandler
{
    /**
     * @param EntityManager $em
     * @param $data
     * @return Texte
     */
    public function createTexte($em, $data)
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
        $titre = $data['titre'];
        $description = $data['description'];
        $type = $data['type'];
        $item = (isset($data['item'])) ? $em->getRepository(AbstractItem::class)->findOneById($data['item']) : $data['item'] = null ;
        $texte = new Texte($titre, $description, $type, $fiction, $item);

        $em->persist($texte);
        $em->flush();

        return $texte;
    }

    /**
     * @param EntityManager $em
     * @param $textes
     * @param $fiction
     * @return bool
     */
    public function createTextes(EntityManager $em, $textes, $fiction, $item)
    {
        foreach ($textes as $data)
        {
            $this->createTexte($em, $data, $fiction, $item);
        }

        return true;
    }
}