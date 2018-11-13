<?php

namespace App\Component\IO;

class ProjetIO extends ElementIO
{
    /**
     * @var bool
     */
    private $public = false;

    /**
     * @return bool
     */
    public function isPublic(): bool
    {
        return $this->public;
    }

    /**
     * @param bool $public
     */
    public function setPublic(bool $public): void
    {
        $this->public = $public;
    }
}
