<?php

namespace Application\Validator\Entity;

use Zend\Validator\Exception;

/**
 * Class AbstractRecordExistsValidator
 * @package Application\Validator\Entity
 */
abstract class AbstractRecordExistsValidator extends AbstractEntityValidator
{

    /**
     * Fetch record.
     *
     * @param mixed $value
     * @return array
     */
    public function fetch($value)
    {
        $entity       = null;
        $excludeValue = null;
        $includeValue = null;

        if (($this->getExclude() || $this->getInclude()) && isset($_POST['data'])) {
            $exclude  = str_replace('_id','', $this->getExclude());
            $include  = str_replace('_id','', $this->getInclude());
            $jsonData = json_decode($_POST['data']);

            if ($exclude && isset($jsonData->{$exclude})) {
                $excludeValue = $jsonData->{$exclude};
            }

            if ($include && isset($jsonData->{$include})) {
                $includeValue = $jsonData->{$include};
            }
        }

        $qb = $this->getEntityManager()
                   ->createQueryBuilder();

        $qb->select('r')
           ->from($this->getRepository(), 'r')
           ->where('r.' . $this->getField() . ' = :value')
           ->setParameter(':value', $value);

        if ($excludeValue) {
            $qb->andWhere('r.' . $this->getExclude() . ' != :exclude')
               ->setParameter(':exclude', $excludeValue);
        }

        if ($includeValue) {
            $qb->andWhere('r.' . $this->getInclude() . ' = :include')
               ->setParameter(':include', $includeValue);
        }

        return $qb->getQuery()->getResult();
    }

}