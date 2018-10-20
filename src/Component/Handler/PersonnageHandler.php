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
            $clone->setPrenom($this->generateNomAtalaire('prenom'));
            $clone->setNom($this->generateNomAtalaire('nom'));

            $genre = (rand(0,1)>0) ?$genre = 'M' :$genre = 'F';
            $clone->setGenre($genre);

            $clone->setAuto(TRUE);
            $clone->setFiction($this->getFiction($fictionId));

            $this->save($clone);
        }

        return true;

    }

    public function generateNomAtalaire($type)
    {
        // calculer le nombre de syllabes
        if ($type === 'prenom') {
            $nbSyllables = $this->computeSyllablesNumberForPrenom(rand(1,100));
        }
        else {
            $nbSyllables = $this->computeSyllablesNumberForNom(rand(1,100));
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
        switch (true){
            case ($randomValue < 30):
            $nbSyllables = 1;
            break;
            case ($randomValue > 30 && $randomValue <70):
            $nbSyllables = 2;
            break;
            default:
            $nbSyllables = 3;
            break;
        }

        return $nbSyllables;
    }

    /**
     * @param $randomValue
     * @return int
     */
    public function computeSyllablesNumberForPrenom($randomValue)
    {
        switch (true){
            case ($randomValue < 10):
                $nbSyllables = 1;
                break;
            case ($randomValue > 10 && $randomValue <70):
                $nbSyllables = 2;
                break;
            case ($randomValue > 80 && $randomValue <90):
                $nbSyllables = 3;
                break;
            default:
                $nbSyllables = 4;
                break;
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
