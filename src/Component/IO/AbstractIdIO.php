<?php

namespace App\Component\IO;

abstract class AbstractIdIO
{
    private $id;

    /**
    * @return mixed
    */
    public function getId()
    {
       return $this->id;
    }

    /**
    * @param mixed $id
    */
    public function setId($id)
    {
       $this->id = $id;
    }

}