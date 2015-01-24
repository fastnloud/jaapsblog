<?php

namespace Application\Validator\Entity;

use Zend\Validator\Exception;

/**
 * Class RecordExists
 * @package Application\Validator\Entity
 */
class RecordExists extends AbstractEntityValidator
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
        $excludeValue = null;

        if ($this->getExclude() && isset($_POST['data'])) {
            $exclude  = $this->getExclude();
            $jsonData = json_decode($_POST['data']);

            if (isset($jsonData->{$exclude})) {
                $excludeValue = $jsonData->{$exclude};
            }
        }

        $qb = $this->getEntityManager()
                   ->createQueryBuilder();

        $qb->select('r')
           ->from($this->getRepository(), 'r')
           ->where('r.' . $this->getField() . ' = :value')
           ->setParameter(':value', $value);

        if ($excludeValue) {
            $qb->andWhere('r.' . $this->getExclude() .' != :exclude')
               ->setParameter(':exclude', $excludeValue);
        }

        return ($qb->getQuery()->getResult() ? true : false);
    }

}