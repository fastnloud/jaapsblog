<?php

namespace Application\Validator\Entity;

use Doctrine\ORM\NoResultException;
use Zend\Validator\Exception;

/**
 * Class NoRecordExists
 * @package Application\Validator\Entity
 */
class NoRecordExists extends AbstractEntityValidator
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
        $id = null;

        if (isset($_POST['data'])) {
            $jsonData = json_decode($_POST['data']);

            if (isset($jsonData->id)) {
                $id = (int) $jsonData->id;
            }
        }

        $qb = $this->getEntityManager()
                   ->createQueryBuilder();

        $qb->select('r')
           ->from($this->getRepository(), 'r')
           ->where('r.' . $this->getField() . ' = :value')
           ->andWhere('r.id != :id')
           ->setParameters(array(
               ':value' => $value,
               ':id'    => $id
           ));

        try {
            $qb->getQuery()
               ->getSingleResult();
        } catch (NoResultException $e) {
            return true;
        }

        return false;
    }

}