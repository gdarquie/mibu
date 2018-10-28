<?php

namespace App\Component\Handler;

use App\Entity\Concept\Action;
use App\Entity\Element\Personnage;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;

class PersonnageHandler extends BaseHandler
{
    /**
     * @param $fictionId
     * @param $limit
     * @return bool
     */
    public function handleGeneratePersonnages($fictionId, $limit)
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

            $dates = $this->computeDates(-100, 60);
            $clone->setAnneeNaissance($dates['dateNaissance']);
            $clone->setAnneeMort($dates['dateMort']);

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
        $syllables = ['ba', 'riu', 'a', 'ta', 'lai', 're', 'da', 'mu', 'ni','no','so', 'mo', 'do', 'ne', 'sa'];

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
     * @param $generationYear
     * @param $periods
     * @param $lifeExpectancy
     * @return array
     */
    public function computeDates($generationYear, $lifeExpectancy, $periods = [18, 35, 65, 100]) :array
    {
            if(count($periods) !== 4) {
                throw new Exception('Length of $periods[] parameters must be 4 for computeDates(), it is '.count($periods));
            }

        $pourcent = rand(0,100);

        //compute the age of the character
        switch($pourcent) {
            case ($pourcent < 25):
                $age = rand(0, $periods[0]);
                break;
            case ($pourcent < 26 && 50):
                $age = rand(($periods[0]+1), $periods[1]);
                break;
            case ($pourcent < 51 && 75):
                $age = rand(($periods[1]+1), $periods[2]);
                break;
            case ($pourcent > 76):
                $age = rand(($periods[2]+1), $periods[3]);
                break;
            default:
                $age = rand($periods[0], $periods[3]);
                break;
        }

        //deduct birth year => dateNaissance
        $dateNaissance = $generationYear - $age;

        //compute lifetime
        $pourcent2 = rand(0,100);

        switch($pourcent2) {
            case ($pourcent < 50):
                $lifeExpectancy = rand($lifeExpectancy-5, $lifeExpectancy+5);
                break;
            case ($pourcent < 51 && 75):
                $lifeExpectancy = rand(0, $lifeExpectancy);
                break;
            case ($pourcent < 76 && 100):
                $lifeExpectancy = rand($lifeExpectancy, 100);
                break;
            default:
                $lifeExpectancy = rand(0, 100); //100 always max?
                break;
        }

        //deduct death year => dateMort
        $dateMort = $dateNaissance + $lifeExpectancy;

        return ['dateNaissance' => $dateNaissance, 'dateMort' => $dateMort];
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

    /**
     * @param $personnageId
     * @param int $debutFiction
     * @param int $finFiction
     * @return mixed
     */
    public function handleGenerateRoutines($personnageId, $debutFiction = -100, $finFiction = -97)
    {
        //get personnages
        $personnage = $this->em->getRepository(Personnage::class)->findOneById($personnageId);

        return $this->createRoutines($personnage);
    }

    public function createRoutines($personnage)
    {
        $debut = $personnage->getAnneeNaissance();
        $fin = $personnage->getAnneeMort();

        //convertir en date

        //création de la routine du début de la journée à la fin

//        for ($heure = 6; $heure <= 22; $heure++) {
//            $routine[$heure] = [$heure => $this->getAction()];
//        }

        $routines[0] = $this->createRoutine();

        return $routines;
    }

    /**
     * @param string $jour
     * @param string $heure
     * @return mixed
     * @throws \Exception
     */
    public function createRoutine($datetime)
    {
        //générer une routine = du lever au sommeil

        dump($datetime);

        //ajouter heure début
        $jour = '5000-01-01';
        $heure = '12:00';
        $format = 'Y-m-d H:i';
        $time = $jour.' '.$heure;

        $datetime = new \DateTime();
        $debutRoutine = $datetime::createFromFormat($format, $time);

        //calcul de la durée de la routine
        $duree = new \DateInterval('PT6H47M');
        $finRoutine = $debutRoutine->add($duree);

        $routine[] = $this->generateActions($debutRoutine, $finRoutine);

        return $routine;
    }

    public function generateActions($debutRoutine, $finRoutine)
    {
        //créer une action
//        while($debutAction >) {
//
//        }

        $action = new Action();
        $action->setDebut($debutRoutine);
        $action->setFin($finRoutine);

        $routine = $action;

        return $routine;
    }

    public function saveRoutines()
    {
        //todo
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        $actions = ['dormir', 'manger', 'travailler', 'lire', 'rêver', 'marcher', 'se battre', 'tuer', 'rire', 'parler', 'rencontrer', 'attendre', 'cuisiner', 'faire le ménage'];

        return $actions[array_rand($actions)];
    }
    
}
