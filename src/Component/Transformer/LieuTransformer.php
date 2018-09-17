<?php

namespace App\Component\Transformer;

use App\Component\IO\LieuIO;

class LieuTransformer extends ElementTransformer
{
    public function convertEntityIntoIO($lieu)
    {
        $lieuIO = new LieuIO();
        $lieuIO = $this->transformElement($lieu, $lieuIO);
        $lieuIO->setLat($lieu->getLat());
        $lieuIO->setLong($lieu->getLong());

        return $lieuIO;
    }


}