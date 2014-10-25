<?php

namespace User\Service;

use Doctrine\ORM\EntityManager;
use Zend\Session\Container;

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

    /**
     * Initialize service. Prepare Auth session and pass the user config to the
     * User Repository.
     */
    public function init()
    {
        $session = new Container('auth');
        if (!$session->isAuthenticated) {
            $session->isAuthenticated = false;
        }

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
     * Fetch isAuthenticated from 'auth' session container.
     *
     * @return bool
     */
    public static function isAuthenticated()
    {
        $session = new Container('auth');

        return (bool) $session->isAuthenticated;
    }

    /**
     * @param boolean $isAuthenticated
     */
    public function setIsAuthenticated($isAuthenticated)
    {
        $session = new Container('auth');
        $session->isAuthenticated = (bool) $isAuthenticated;
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