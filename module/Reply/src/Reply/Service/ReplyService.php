<?php

namespace Reply\Service;

use Application\Service\AbstractEntityService;

/**
 * Class ReplyService
 * @package Reply\Service
 */
class ReplyService extends AbstractEntityService
{

    /**
     * @return mixed
     */
    public function fetchEntities()
    {
        return $this->getEntityManager()
                    ->getRepository('Reply\Entity\Reply')
                    ->setQueryHydrator($this->getQueryHydrator())
                    ->fetchEntities();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function fetchEntity($id)
    {
        return $this->getEntityManager()
                    ->getRepository('Reply\Entity\Reply')
                    ->setQueryHydrator($this->getQueryHydrator())
                    ->fetchEntity($id);
    }

}