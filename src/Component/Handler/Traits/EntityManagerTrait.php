<?php

namespace App\Component\Handler\Traits;

class EntityManagerTrait
{
    public function getEntityManager()
    {
        return $this->getMainManager()->getEntityManager();
    }
}