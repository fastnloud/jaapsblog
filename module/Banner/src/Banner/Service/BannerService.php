<?php

namespace Banner\Service;

use Application\Service\AbstractEntityService;

/**
 * Class BannerService
 * @package Banner\Service
 */
class BannerService extends AbstractEntityService
{

    /**
     * @return mixed
     */
    public function fetchEntities()
    {
        return $this->getEntityManager()
                    ->getRepository('Banner\Entity\Banner')
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
                    ->getRepository('Banner\Entity\Banner')
                    ->setQueryHydrator($this->getQueryHydrator())
                    ->fetchEntity($id);
    }

}