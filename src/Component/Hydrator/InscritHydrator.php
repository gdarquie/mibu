<?php

namespace App\Component\Hydrator;

use App\Entity\Concept\Inscrit;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class InscritHydrator extends ConceptHydrator
{
//    private $passwordEncoder;
//
//    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
//    {
//        $this->passwordEncoder = $passwordEncoder;
//    }

    public function hydrateInscrit(Inscrit $inscrit, $data)
    {
        $inscrit = parent::hydrateConcept($inscrit, $data);

        $inscrit->setPseudo($data['pseudo']);
        $inscrit->setPrenom($data['prenom']);
        $inscrit->setNom($data['nom']);
//        $inscrit->setPassword($this->passwordEncoder->encodePassword(
//            $inscrit,
//            $data['mdp']
//        ));
        $inscrit->setPassword(
            $data['password']
        );

        $inscrit->setGenre($data['genre']);
        $inscrit->setDateNaissance(new \DateTime($data['dateNaissance']));
        $inscrit->setEmail($data['email']);

        return $inscrit;
    }
}