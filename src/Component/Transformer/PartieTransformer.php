<?php

namespace App\Component\Transformer;

use App\Component\Constant\ModelType;
use App\Component\IO\PartieIO;

class PartieTransformer extends ElementTransformer
{
    public function convertEntityIntoIO($partie)
    {
        $partieIO = new PartieIO();
        $partieIO = $this->transformElement($partie, $partieIO, ModelType::PARTIE);
        //textes

        return $partieIO;
    }


}