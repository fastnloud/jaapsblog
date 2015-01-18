<?php

namespace Application\Validator\Entity;

use Zend\Validator\Exception;

class RecordExists extends AbstractEntityValidator
{

    /**
     * Confirms a record exist in a table.
     *
     * @param  mixed $value
     * @return bool
     * @throws Exception\RuntimeException If validation of $value is impossible
     */
    public function isValid($value)
    {
        $record = $this->getEntityManager()
                       ->getRepository($this->getRepository())
                       ->findOneBy(array(
                           $this->getField() => $value
                       ));

        return ($record ? true : false);
    }

}