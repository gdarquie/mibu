<?php

namespace App\Component\IO;

class ElementIO extends AbstractConceptIO
{
    /**
     * @var string
     */
    private $fiction_id;

    /**
     * @return mixed
     */
    public function getFictionId()
    {
        return $this->fiction_id;
    }

    /**
     * @param mixed $fiction_id
     */
    public function setFictionId($fiction_id)
    {
        $this->fiction_id = $fiction_id;
    }

}