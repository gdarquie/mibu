<?php

namespace App\Component\Handler;

use App\Component\Fetcher\FictionFetcher;
use App\Component\Hydrator\PersonnageHydrator;
use App\Component\Transformer\PersonnageTransformer;
use App\Entity\Element\Personnage;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class ElementHandler extends BaseHandler
{
    public function getFiction($fictionId)
    {
        $fictionFetcher = new FictionFetcher($this->em);

        if(!$fictionId) {
            throw new BadRequestHttpException(sprintf(
                "Il n'y a pas de fiction liée à cet élément."
            ));
        }

        return $fictionFetcher->fetchFiction($fictionId);
    }

    /**
     * @param $data
     * @param $modelType
     * @return \App\Component\IO\PersonnageIO|array|mixed
     */
    public function postElement($data, $modelType) {
        switch ($modelType) {
            case 'personnage':
                $element = new Personnage($data['titre'], $data['description'], isset($data['itemId']));
                $hydrator = new PersonnageHydrator();
                $transformer = new PersonnageTransformer();
                break;
            default:
                throw new UnauthorizedHttpException(sprintf(
                "Aucun modelType n'est renseigné."
            ));
        }

        if(!isset($data['fictionId'])){
            throw new UnauthorizedHttpException(sprintf(
                "Le champ fictionId n'est pas renseigné."
            ));
        }

        $data['fiction'] = $this->getFiction($data['fictionId']);
        $element = $hydrator->hydratePersonnage($element, $data);
        $this->save($element);
        $personnageIO = $transformer->convertEntityIntoIO($element);

        return $personnageIO;
    }
}