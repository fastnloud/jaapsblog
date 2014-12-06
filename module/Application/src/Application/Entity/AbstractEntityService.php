<?php

namespace Application\Entity;

use Application\Entity\Exception\EntityException;
use Doctrine\Common\Util\Debug;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use Zend\Form\Form;
use Zend\InputFilter\InputFilterAwareInterface;

abstract class AbstractEntityService
{

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var int
     */
    protected $queryHydrator = Query::HYDRATE_OBJECT;

    /**
     * Merge Entity with given JSON object. Note; the Entity will be detached
     * so validation can be applied.
     *
     * @param \stdClass $jsonObject
     * @param $entity
     * @return mixed
     */
    public function mergeEntityWithJsonObject($entity, \stdClass $jsonObject)
    {
        $this->getEntityManager()
             ->detach($entity);

        foreach ($jsonObject as $key => $value) {
            $var    = str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
            $setter = 'set' . $var;

            if (is_callable(array($entity, $setter))) {
                try {
                    $entity->$setter($value);
                } catch(EntityException $e) {
                    $getter     = 'get' . $var;
                    $repository = get_class($entity->$getter());

                    $joinedEntity = $this->getEntityManager()
                                         ->getRepository($repository)
                                         ->find($value);

                    if ($joinedEntity) {
                        $entity->$setter($joinedEntity);
                    }
                }
            }
        }

        return $entity;
    }

    /**
     * Save or merge (update) detached entity.
     *
     * @param $entity
     * @param bool $merge
     * @return bool
     */
    public function saveEntity($entity, $merge = false)
    {
        if (true === $merge) {
            return (bool) $this->getEntityManager()
                               ->merge($entity);
        } else {
            $this->getEntityManager()
                 ->persist($entity);

            $this->getEntityManager()
                 ->flush();
        }

        return (bool) $entity;
    }

    /**
     * Delete given entity.
     *
     * @param $entity
     * @return mixed
     */
    public function deleteEntity($entity)
    {
        $this->getEntityManager()
             ->remove($entity);

        return $entity;
    }

    /**
     * Validate given Entity object.
     *
     * @param InputFilterAwareInterface $entity
     * @return bool
     */
    public function validateEntity(InputFilterAwareInterface $entity)
    {
        $form = new Form();
        $form->bind($entity);

        return $form->isValid();
    }

    /**
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @param int $queryHydrator
     * @return $this
     */
    public function setQueryHydrator($queryHydrator)
    {
        $this->queryHydrator = (int) $queryHydrator;

        return $this;
    }

    /**
     * @return int
     */
    protected function getQueryHydrator()
    {
        return (int) $this->queryHydrator;
    }

}