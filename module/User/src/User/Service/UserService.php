<?php

namespace User\Service;

use Application\Service\AbstractEntityService;
use Doctrine\ORM\NoResultException;

/**
 * Class UserService
 * @package User\Service
 */
class UserService extends AbstractEntityService
{

    /**
     * @var array
     */
    protected $config = array();

    /**
     * Pass the user config to the User Repository.
     *
     * @return void
     */
    public function init()
    {
        $this->getEntityManager()
             ->getRepository('User\Entity\User')
             ->setConfig($this->getConfig());
    }

    /**
     * Fetch entity.
     *
     * @param int $id
     * @return mixed|void
     * @throws \Doctrine\ORM\NoResultException
     */
    public function fetchEntity($id)
    {
        throw new NoResultException;
    }

    /**
     * Fetch Entities.
     *
     * @return mixed|void
     * @throws \Doctrine\ORM\NoResultException
     */
    public function fetchEntities()
    {
        throw new NoResultException;
    }

    /**
     * Check for existing users.
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