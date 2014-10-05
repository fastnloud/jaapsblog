<?php

namespace Page\Service;

use Doctrine\ORM\EntityManager;
use Page\Entity\Page as PageEntity;

class Page
{

    /**
     * @var EntityManager
     */
    protected $entityManager;

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

}