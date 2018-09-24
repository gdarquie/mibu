<?php

namespace App\Component\Transformer;

use App\Component\Constant\ModelType;
use App\Component\IO\LieuIO;

class LieuTransformer extends ElementTransformer
{
    public function convertEntityIntoIO($lieu)
    {
        $lieuIO = new LieuIO();
        $lieuIO = $this->transformElement($lieu, $lieuIO, ModelType::LIEU);
        $lieuIO->setLat($lieu->getLat());
        $lieuIO->setLong($lieu->getLong());

        return $lieuIO;
    }


}