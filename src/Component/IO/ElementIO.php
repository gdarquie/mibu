<?php

namespace App\Component\IO;

class ElementIO extends AbstractConceptIO
{
    /**
     * @var string
     */
    private $fiction_id;

    /**
     * @var string
     */
    private $item_id;

    /**
     * @return mixed
     */
    public function getFictionId(): string
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

    /**
     * @return string
     */
    public function getItemId(): ?string
    {
        return $this->item_id;
    }

    /**
     * @param string $item_id
     */
    public function setItemId(string $item_id)
    {
        $this->item_id = $item_id;
    }

}