<?php

namespace Application\Entity;

/**
 * Class AbstractEntity
 * @package Application\Entity
 */
abstract class AbstractEntity
{

    /**
     * @return array
     */
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}