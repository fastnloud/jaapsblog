<?php

namespace User\Entity;

use Doctrine\ORM\EntityRepository;
use Zend\Crypt\Password\Bcrypt;

class UserRepository extends EntityRepository
{

    /**
     * @var array
     */
    protected $config;

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
        $user->setUser($defaultUser['user']);
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
            $bcrypt   = new Bcrypt(array(
                'salt' => $this->getConfig()['bcrypt']['salt'],
                'cost' => $this->getConfig()['bcrypt']['cost']
            ));

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