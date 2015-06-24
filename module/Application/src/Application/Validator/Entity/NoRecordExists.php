<?php

namespace Application\Validator\Entity;

use Zend\Validator\Exception;

/**
 * Class NoRecordExists
 * @package Application\Validator\Entity
 */
class NoRecordExists extends AbstractRecordExistsValidator
{

    /**
     * Confirms a record does not exist in a table.
     *
     * @param  mixed $value
     * @return bool
     * @throws Exception\RuntimeException If validation of $value is impossible
     */
    public function isValid($value)
    {
        return ($this->fetch($value) ? false : true);
    }

}