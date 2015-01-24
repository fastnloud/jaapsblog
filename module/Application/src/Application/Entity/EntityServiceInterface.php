<?php

namespace Application\Entity;

/**
 * Interface EntityServiceInterface
 * @package Application\Entity
 */
interface EntityServiceInterface
{

    /**
     * Fetch entity.
     *
     * @param int $id
     * @return mixed
     */
    public function fetchEntity($id);

    /**
     * Fetch entities.
     *
     * @return mixed
     */
    public function fetchEntities();

    /**
     * @param AbstractEntity $entity
     * @return mixed
     */
    public function destroyEntity(AbstractEntity $entity);

}