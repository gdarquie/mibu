<?php

namespace App\Component\Handler;

use App\Component\Constant\ModelType;

class TexteHandler extends BaseHandler
{
    /**
     * @param $textes
     *
     * @return bool
     */
    public function createTextes($textes)
    {
        foreach ($textes as $data) {
            $this->postEntity($data, modelType::TEXTE);
        }

        return true;
    }
}
