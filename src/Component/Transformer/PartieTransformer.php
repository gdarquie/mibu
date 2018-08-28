<?php

namespace App\Component\Transformer;

use App\Component\IO\PartieIO;

class PartieTransformer extends ElementTransformer
{
    public function hydratePartie($partie)
    {
        $partieIO = new PartieIO();
        $partieIO = $this->transformElement($partie, $partieIO);
        //textes

        return $partieIO;
    }

}