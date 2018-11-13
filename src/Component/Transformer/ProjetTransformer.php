<?php

namespace App\Component\Transformer;

use App\Component\Constant\ModelType;
use App\Component\IO\ProjetIO;

class ProjetTransformer extends ElementTransformer
{
    public function convertEntityIntoIO($projet)
    {
        $projetIO = new ProjetIO();
        $projetIO = $this->transformElement($projet, $projetIO, ModelType::PROJET);
        $projetIO->setPublic($projet->isPublic());

        return $projetIO;
    }
}

