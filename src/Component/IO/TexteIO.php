<?php
/**
 * Created by PhpStorm.
 * User: gaetan
 * Date: 20/03/2018
 * Time: 09:27
 */

namespace App\Component\IO;


class TexteIO
{
    private $titre;
    private $contenu;
    private $fiction;

    /**
     * @return mixed
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * @param mixed $titre
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
    }

    /**
     * @return mixed
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * @param mixed $contenu
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;
    }

    /**
     * @return mixed
     */
    public function getFiction()
    {
        return $this->fiction;
    }

    /**
     * @param mixed $fiction
     */
    public function setFiction($fiction)
    {
        $this->fiction = $fiction;
    }


}