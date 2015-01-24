<?php

namespace User\Entity;

use Doctrine\ORM\EntityRepository;
use Zend\Crypt\Password\Bcrypt;

/**
 * Class UserRepository
 * @package User\Entity
 */
class UserRepository extends EntityRepository
{

    /**
     * @var array
     */
    protected $config = array();

    /**
     * @return bool
     */
    public function hasUsers()
    {
        return (bool) count($this->findAll());
    }

    /**
     * @param array $defaultUser
     * @return User
     */
    public function addDefaultUser(array $defaultUser)
    {
        $user = new User();
        $user->setUsername($defaultUser['username']);
        $user->setPassword($defaultUser['password']);

        return $this->addUser($user);
    }

    /**
     * @param User $user
     * @return User
     */
    public function addUser(User $user)
    {
        $this->applyHashing($user);

        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();

        return $user;
    }

    /**
     * @param User $user
     */
    protected function applyHashing(User $user)
    {
        $password = $user->getPassword();

        if ($password) {
            $bcrypt = new Bcrypt($this->getConfig()['bcrypt']);

            $user->setPassword(
                $bcrypt->create($password)
            );
        }
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