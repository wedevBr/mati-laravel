<?php

namespace WeDevBr\Mati\Inputs;

/**
 * Trait for inputs that have a type
 *
 * @author Gabriel Mineiro <gabrielpfgmineiro@gmail.com>
 */
trait HasType
{
    protected $type;

    /**
     * @param string $type
     * @return static
     */
    public function setType(string $type)
    {
        $this->type = $type;
        return $this;
    }
}
