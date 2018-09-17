<?php

namespace App\Component\Transformer;

use App\Component\IO\PartieIO;

class PartieTransformer extends ElementTransformer
{
    //todo : supprimer quand refacto Partie Controller et handler finie
//    public function hydratePartie($partie)
//    {
//        $partieIO = new PartieIO();
//        $partieIO = $this->transformElement($partie, $partieIO);
//        //textes
//
//        return $partieIO;
//    }

    public function convertEntityIntoIO($partie)
    {
        $partieIO = new PartieIO();
        $partieIO = $this->transformElement($partie, $partieIO);
        //textes

        return $partieIO;
    }


}