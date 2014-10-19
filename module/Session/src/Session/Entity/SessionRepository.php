<?php

namespace Session\Entity;

use Doctrine\ORM\EntityRepository;
use Zend\Debug\Debug;

class SessionRepository extends EntityRepository
{

    /**
     * @var bool
     */
    protected $debug = false;

    /**
     * @param $id
     * @param $name
     * @return string
     */
    public function read($id, $name)
    {
        $data          = '';
        $storedSession = $this->findOneBy(array(
            'id'   => $id,
            'name' => $name
        ));

        if ($storedSession) {
            if ($storedSession->getModified() + $storedSession->getLifetime() > time()) {
                $data = $storedSession->getData();

                if ($this->getDebug()) {
                    Debug::dump('session read');
                    Debug::dump($data);
                }

                return $data;
            }

            $this->destroy($storedSession->getId(), $storedSession->getName());
            $this->getEntityManager()->flush();
        }

        if ($this->getDebug()) {
            Debug::dump($data);
        }

        return $data;
    }

    /**
     * @param Session $session
     * @return bool
     */
    public function write(Session $session)
    {
        $storedSession = $this->findOneBy(array(
            'id'   => $session->getId(),
            'name' => $session->getName()
        ));

        if ($storedSession) {
            $storedSession->setData($session->getData());
            $storedSession->setModified($session->getModified());
            $this->getEntityManager()->flush();

            if ($this->getDebug()) {
                Debug::dump('session write (updated)');
                Debug::dump($storedSession);
            }

            return (bool) $storedSession;
        }

        $this->getEntityManager()->persist($session);
        $this->getEntityManager()->flush();

        if ($this->getDebug()) {
            Debug::dump('session write (new)');
            Debug::dump($session);
        }

        return (bool) $session;
    }

    /**
     * @param $id
     * @param $name
     * @return bool
     */
    public function destroy($id, $name)
    {
        $storedSession = $this->findOneBy(array(
            'id'   => $id,
            'name' => $name
        ));

        if ($storedSession) {
            $this->getEntityManager()->remove($storedSession);
            $this->getEntityManager()->flush();

            if ($this->getDebug()) {
                Debug::dump('session destroy');
            }
        }

        if ($this->getDebug()) {
            Debug::dump($storedSession);
        }

        return (bool) $storedSession;
    }

    /**
     * @param $maxlifetime
     * @return bool
     */
    public function gc($maxlifetime)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->delete('Session\Entity\Session', 's');
        $qb->where('s.modified < :maxlifetime');
        $qb->setParameter(':maxlifetime', time() - $maxlifetime);

        if ($this->getDebug()) {
            Debug::dump('session gc called');
            Debug::dump($qb->getDQL());
        }

        return (bool) $qb->getQuery()
                         ->execute();
    }

    /**
     * @param $debug
     * @return $this
     */
    public function setDebug($debug)
    {
        $this->debug = (bool) $debug;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getDebug()
    {
        return (bool) $this->debug;
    }

}