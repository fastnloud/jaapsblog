<?php

namespace Application\Service;

use Application\Entity\AbstractEntity;

/**
 * Interface EntityServiceInterface
 * @package Application\Service
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