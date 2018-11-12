<?php

namespace App\Component\Handler;

use App\Entity\Element\Projet;

class ProjetHandler extends BaseHandler
{
    public function isProjetPublic($id)
    {
        $projet = $this->em->getRepository(Projet::class)->findOneById($id);
        return $projet->isPublique();
    }
}

