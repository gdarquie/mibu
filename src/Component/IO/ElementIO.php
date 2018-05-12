<?php

namespace App\Component\IO;

class ElementIO extends AbstractConceptIO
{
    private $fiction;

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