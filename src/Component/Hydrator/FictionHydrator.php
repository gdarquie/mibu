<?php

namespace App\Component\Hydrator;

class FictionHydrator
{
    public function hydrateFiction($fiction, $data)
    {
        ($data['titre']) ? $fiction->setTitre($data['titre']) : '';
        ($data['description']) ? $fiction->setDescription($data['description']) : '';

        return $fiction;
    }
}