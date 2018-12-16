<?php

namespace App\Component\Handler;

class InscritHandler extends BaseHandler
{
    /**
     * @param $modelType
     *
     * @return mixed
     */
    public function getEntityHydrator($modelType)
    {
        $className = 'App\Component\Hydrator\\'.ucfirst($modelType).'Hydrator';

        return new $className($this->passwordEncoder);
    }
}
