<?php

namespace User\Service;

use Doctrine\ORM\EntityManager;

class User
{

    /**
     * @var array
     */
    protected $config;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    public function init()
    {
        $this->getEntityManager()
             ->getRepository('User\Entity\User')
             ->setConfig($this->getConfig());
    }

    /**
     * Table has users?
     *
     * @return bool
     */
    public function hasUsers()
    {
        return $this->getEntityManager()
                    ->getRepository('User\Entity\User')
                    ->hasUsers();
    }

    /**
     * Add default user from config.
     *
     * @return \User\Entity\User
     */
    public function addDefaultUser()
    {
        return $this->getEntityManager()
                    ->getRepository('User\Entity\User')
                    ->addDefaultUser($this->getConfig()['user']['default_user']);
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
     * @param array $config
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
    }

    /**
     * @return array
     */
    protected function getConfig()
    {
        return $this->config;
    }

}