<?php

namespace Session\Service;

use Session\Entity\Session;
use Zend\Session\SaveHandler\SaveHandlerInterface;
use Doctrine\ORM\EntityManager;

class SessionSaveHandler implements SaveHandlerInterface
{

    /**
     * @var array
     */
    protected $config;

    /**
     * @var string
     */
    protected $sessionSavePath;

    /**
     * @var string
     */
    protected $sessionName;

    /**
     * @var int
     */
    protected $lifetime;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * Retrieve resources.
     *
     * @param string $savePath
     * @param string $name
     */
    public function open($savePath, $name)
    {
        $this->setSessionSavePath($savePath);
        $this->setSessionName($name);
        $this->setLifetime(ini_get('session.gc_maxlifetime'));
    }

    /**
     * Free resources.
     *
     * @return bool
     */
    public function close()
    {
        return true;
    }

    /**
     * Read session data.
     *
     * @param string $id
     */
    public function read($id)
    {
        $config = $this->getConfig();

        return $this->getEntityManager()
                    ->getRepository('Session\Entity\Session')
                    ->setDebug($config['debug'])
                    ->read($id, $this->getSessionName());
    }

    /**
     * Commit data to resource.
     *
     * @param string $id
     * @param mixed $data
     */
    public function write($id, $data)
    {
        $config = $this->getConfig();

        $session = new Session();
        $session->setName($this->getSessionName());
        $session->setLifetime($this->getLifetime());
        $session->setModified(time());
        $session->setId($id);
        $session->setData($data);

        return $this->getEntityManager()
                    ->getRepository('Session\Entity\Session')
                    ->setDebug($config['debug'])
                    ->write($session);
    }

    /**
     * Remove data from resource for given session id.
     *
     * @param string $id
     */
    public function destroy($id)
    {
        $config = $this->getConfig();

        return $this->getEntityManager()
                    ->getRepository('Session\Entity\Session')
                    ->setDebug($config['debug'])
                    ->destroy($id, $this->getSessionName());
    }

    /**
     * Remove old session data older than $maxlifetime (in seconds).
     *
     * @param int $maxlifetime
     */
    public function gc($maxlifetime)
    {
        $config = $this->getConfig();

        return $this->getEntityManager()
                    ->getRepository('Session\Entity\Session')
                    ->setDebug($config['debug'])
                    ->gc($maxlifetime);
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
     * @param int $lifetime
     */
    protected function setLifetime($lifetime)
    {
        $this->lifetime = (int) $lifetime;
    }

    /**
     * @return int
     */
    protected function getLifetime()
    {
        return (int) $this->lifetime;
    }

    /**
     * @param string $sessionName
     */
    protected function setSessionName($sessionName)
    {
        $this->sessionName = $sessionName;
    }

    /**
     * @return string
     */
    protected function getSessionName()
    {
        return $this->sessionName;
    }

    /**
     * @param string $sessionSavePath
     */
    protected function setSessionSavePath($sessionSavePath)
    {
        $this->sessionSavePath = $sessionSavePath;
    }

    /**
     * @return string
     */
    protected function getSessionSavePath()
    {
        return $this->sessionSavePath;
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
    public function getConfig()
    {
        return $this->config;
    }

}