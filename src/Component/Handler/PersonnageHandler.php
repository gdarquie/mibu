<?php

namespace App\Component\Handler;

use App\Entity\Element\Personnage;
use Symfony\Component\HttpFoundation\JsonResponse;

class PersonnageHandler extends BaseHandler
{
    /**
     * @param $fictionId
     * @param $limit
     * @return bool
     */
    public function generatePersonnages($fictionId, $limit)
    {
        if($limit > 1000) {
            $limit = 1000;
        }

        $personnage = new Personnage('Original', 'Le personnage original');

        for($i= 0; $i < $limit; $i++) {
            $clone = clone $personnage;

            $clone->setTitre('Clone n°'.($i+1));
            $clone->setDescription('Un clone');
            $clone->setPrenom($this->generatePrenomAtalaire());
            $clone->setNom($this->generateNomAtalaire());

            $genre = (rand(0,1)>0) ?$genre = 'M' :$genre = 'F';
            $clone->setGenre($genre);

            $clone->setAuto(TRUE);
            $clone->setFiction($this->getFiction($fictionId));

            $this->save($clone);
        }

        return true;

    }

    /**
     * @return array|string
     */
    public function generatePrenomAtalaire():string
    {
        // calculer le nombre de syllabes
        $rand = rand(1,100);

        if($rand < 10) {
            $nbSyllables = 1;
        }

        else if($rand > 10 && $rand <70) {
            $nbSyllables = 2;
        }

        else if ($rand > 70 && $rand <90) {
            $nbSyllables = 3;
        }

        else {
            $nbSyllables = 4;
        }

        // liste des syllabes
        $syllables = ['ba', 'rius', 'a', 'ta', 'lai', 're', 'da', 'mu', 'ni','no','so', 'mo', 'do', 'lne', 'sa'];

        // assemblage des syllabes
        for ($i = 0; $i < $nbSyllables; $i++) {
            $prenom[] = $syllables[array_rand($syllables, 1)];
        }

        // créer le prénom
        $prenom = ucfirst(implode($prenom));

        return $prenom;
    }

    /**
     * @return string
     */
    public function generateNomAtalaire():string
    {
        // calculer le nombre de syllabes
        $rand = rand(1,100);

        if($rand < 30) {
            $nbSyllables = 1;
        }

        else if($rand > 30 && $rand <70) {
            $nbSyllables = 2;
        }

        else {
            $nbSyllables = 3;
        }

        // liste des syllabes
        $syllables = ['ba', 'rius', 'a', 'ta', 'lai', 're', 'da', 'mu', 'ni','no','so', 'mo', 'do', 'lne', 'sa'];

        // assemblage des syllabes
        for ($i = 0; $i < $nbSyllables; $i++) {
            $nom[] = $syllables[array_rand($syllables, 1)];
        }

        // créer le nom
        $nom = ucfirst(implode($nom));

        return $nom;
    }

    public function getFictionStats($fictionId)
    {
        $nb_personnages = $this->em->getRepository(Personnage::class)->countPersonnages($fictionId);
        $nb_women = $this->em->getRepository(Personnage::class)->countNbWomen($fictionId);
        $nb_men = $this->em->getRepository(Personnage::class)->countNbMen($fictionId);
        $ratio_women = 100/$nb_personnages*$nb_women;
        $average_age= $this->em->getRepository(Personnage::class)->countAverageAge($fictionId);

        return new JsonResponse('Les stats sont : - nombre de personnages = '.$nb_personnages.' dont '.$nb_women.' soit un ratio de'.$ratio_women.'% de personnages féminins, l\'âge moyen est de '.$average_age);
    }
}