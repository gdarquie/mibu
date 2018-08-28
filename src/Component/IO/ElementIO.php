<?php

namespace App\Component\IO;

class ElementIO extends AbstractConceptIO
{
    /**
     * @var string
     */
    private $fictionId;

    /**
     * @var string
     */
    private $itemId;

    /**
     * @return mixed
     */
    public function getFictionId(): ?string
    {
        return $this->fictionId;
    }

    /**
     * @param mixed $fictionId
     */
    public function setFictionId($fictionId)
    {
        $this->fictionId = $fictionId;
    }

    /**
     * @return string
     */
    public function getItemId(): ?string
    {
        return $this->itemId;
    }

    /**
     * @param string $itemId
     */
    public function setItemId(string $itemId)
    {
        $this->itemId = $itemId;
    }

}