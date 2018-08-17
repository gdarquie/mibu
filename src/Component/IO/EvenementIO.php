<?php

namespace App\Component\IO;

class EvenementIO extends ElementIO
{
    private $anneeDebut;
    private $anneeFin;

    /**
     * @return mixed
     */
    public function getAnneeDebut()
    {
        return $this->anneeDebut;
    }

    /**
     * @param mixed $anneeDebut
     */
    public function setAnneeDebut($anneeDebut)
    {
        $this->anneeDebut = $anneeDebut;
    }

    /**
     * @return mixed
     */
    public function getAnneeFin()
    {
        return $this->anneeFin;
    }

    /**
     * @param mixed $anneeFin
     */
    public function setAnneeFin($anneeFin)
    {
        $this->anneeFin = $anneeFin;
    }

}