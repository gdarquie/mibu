<?php

namespace App\Component\Handler;

use App\Component\Fetcher\FictionFetcher;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ElementHandler extends BaseHandler
{
    public function getFiction($fictionId)
    {
        //fetch fiction
        $fictionFetcher = new FictionFetcher($this->em);

        if(!$fictionId) {
            throw new BadRequestHttpException(sprintf(
                "Il n'y a pas de fiction liée à cet élément."
            ));
        }

        return $fictionFetcher->fetchFiction($fictionId);
    }
}