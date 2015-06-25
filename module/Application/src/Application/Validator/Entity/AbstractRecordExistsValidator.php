<?php

namespace Application\Validator\Entity;

use Application\Entity\AbstractEntity;
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

        if ($value instanceof AbstractEntity) {
            $valueGetter = 'get' . str_replace(' ', '', ucwords(str_replace('_', ' ', $this->getField())));
            $value       = $value->$valueGetter();
        }

        if (($this->getExclude() || $this->getInclude()) && isset($_POST['data'])) {
            $exclude        = str_replace('_id','', $this->getExclude());
            $excludeGetter  = 'get' . str_replace(' ', '', ucwords(str_replace('_', ' ', $exclude)));

            $include        = str_replace('_id','', $this->getInclude());
            $includeGetter  = 'get' . str_replace(' ', '', ucwords(str_replace('_', ' ', $include)));

            $jsonData = json_decode($_POST['data']);

            if (isset($jsonData->id) && is_numeric($jsonData->id)) {
                $entity = $this->getEntityManager()
                               ->getRepository($this->getRepository())
                               ->fetchEntity($jsonData->id);
            }

            if ($exclude && isset($jsonData->{$exclude})) {
                $excludeValue = $jsonData->{$exclude};
            }

            if ($exclude && empty($excludeValue) && $entity) {
                $excludeValue = $entity->$excludeGetter();

                if ($excludeValue instanceof AbstractEntity) {
                    $excludeValue = $excludeValue->getId();
                }
            }

            if ($include && isset($jsonData->{$include})) {
                $includeValue = $jsonData->{$include};
            }

            if ($include && empty($includeValue) && $entity) {
                $includeValue = $entity->$includeGetter();

                if ($includeValue instanceof AbstractEntity) {
                    $includeValue = $includeValue->getId();
                }
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