<?php

namespace App\Component\Handler;

use App\Entity\Element\Personnage;

class PersonnageHandler extends BaseHandler
{
    public function generatePersonnages($fictionId, $limit)
    {
        if($limit > 1000) {
            $limit = 1000;
        }

        $personnages = [];
        $personnage = new Personnage('Original', 'Le personnage original');

        for($i= 0; $i < $limit; $i++) {
            $clone = clone $personnage;
            //changeId
            $clone->setTitre('Clone n°'.($i+1));
            $clone->setDescription('Un clone');
            $clone->setPrenom($this->generatePrenomAtalaire());
            $clone->setNom($this->generateNomAtalaire());

            $genre = (rand(0,1)>0) ?$genre = 'M' :$genre = 'F';
            $clone->setGenre($genre);

            $clone->setAuto(TRUE);
            $clone->setFiction($this->getFiction($fictionId));

            $this->save($clone);
            array_push($personnages, $clone);

            //save every perso
        }

        return true;

    }

    public function generatePrenomAtalaire()
    {
        //nb de syllabe 1 à 3
        // assemblage de syllabe
        $prenom = 'Atalaire';

        return $prenom;
    }

    public function generateNomAtalaire()
    {
        //nb de syllabe 1 à 3
        // assemblage de syllabe
        $prenom = 'Atalaire';

        return $prenom;
    }
}