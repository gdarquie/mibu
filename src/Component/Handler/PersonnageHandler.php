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
        $nbSyllables = $this->computeSyllablesNumberForPrenom(rand(1,100));

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
        $nbSyllables = $this->computeSyllablesNumberForNom(rand(1,100));

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

    /**
     * @param $fictionId
     * @return JsonResponse
     */
    public function getFictionStats($fictionId)
    {
        $nb_personnages = $this->em->getRepository(Personnage::class)->countPersonnages($fictionId);
        $nb_women = $this->em->getRepository(Personnage::class)->countNbWomen($fictionId);
        $nb_men = $this->em->getRepository(Personnage::class)->countNbMen($fictionId);
        $ratio_women = round(100/$nb_personnages*$nb_women, 2);
        $average_age= round($this->em->getRepository(Personnage::class)->countAverageAge($fictionId),1);

        $payload = [
            'nb_personnages' => $nb_personnages,
            'nb_women' => $nb_women,
            'nb_men' => $nb_men,
            'ratio_women' => $ratio_women,
            'average_age' => $average_age
        ];

        return new JsonResponse($payload);
    }

    /**
     * @param $randomValue
     * @return int
     */
    public function computeSyllablesNumberForNom($randomValue)
    {
        if($randomValue < 30) {
            $nbSyllables = 1;
        }

        else if($randomValue > 30 && $randomValue <70) {
            $nbSyllables = 2;
        }

        else {
            $nbSyllables = 3;
        }

        return $nbSyllables;
    }

    /**
     * @param $randomValue
     * @return int
     */
    public function computeSyllablesNumberForPrenom($randomValue)
    {
        if($randomValue < 10) {
            $nbSyllables = 1;
        }

        else if($randomValue > 10 && $randomValue <70) {
            $nbSyllables = 2;
        }

        else if ($randomValue > 70 && $randomValue <90) {
            $nbSyllables = 3;
        }

        else {
            $nbSyllables = 4;
        }

        return $nbSyllables;

    }

    /**
     * @param $fictionId
     * @return mixed
     */
    public function handleDeleteGenerated($fictionId)
    {
        $this->em->getRepository(Personnage::class)->deleteGenerated($fictionId);

        return new JsonResponse('Suppression des personnages générés automatiquement', 200);

    }
    
}
