<?php

namespace Application\Validator\Entity;

use Zend\Validator\Exception;

/**
 * Class RecordExists
 * @package Application\Validator\Entity
 */
class RecordExists extends AbstractRecordExistsValidator
{

    /**
     * Confirms a record exists in a table.
     *
     * @param  mixed $value
     * @return bool
     * @throws Exception\RuntimeException If validation of $value is impossible
     */
    public function isValid($value)
    {
        return ($this->fetch($value) ? true : false);
    }

}