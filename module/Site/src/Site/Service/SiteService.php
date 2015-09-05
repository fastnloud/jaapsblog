<?php

namespace Site\Service;

use Site\Entity\Site;
use Doctrine\ORM\NoResultException;
use Zend\Http\Request;
use Zend\Stdlib\RequestInterface;
use Application\Service\AbstractEntityService;

/**
 * Class SiteService
 * @package Site\Service
 */
class SiteService extends AbstractEntityService
{

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * Load and fetch 'active' site by domain.
     *
     * @return void
     */
    public function load()
    {
        if ($this->getRequest() instanceof Request) {
            $host = $this->getRequest()
                         ->getUri()
                         ->getHost();

            try {
                $site = $this->fetchSiteByDomain($host);
            } catch(NoResultException $e) {
                $site = new Site();
                $site->setTitle('Undefined App');
            }
        }
    }

    /**
     * @return mixed
     */
    public function fetchEntities()
    {
        return $this->getEntityManager()
                    ->getRepository('Site\Entity\Site')
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
                    ->getRepository('Site\Entity\Site')
                    ->setQueryHydrator($this->getQueryHydrator())
                    ->fetchEntity($id);
    }

    /**
     * @param string $domain
     * @return mixed
     */
    public function fetchSiteByDomain($domain)
    {
        return $this->getEntityManager()
                    ->getRepository('Site\Entity\Site')
                    ->setQueryHydrator($this->getQueryHydrator())
                    ->fetchSiteByDomain($domain);
    }

    /**
     * @param \Zend\Stdlib\RequestInterface $request
     */
    public function setRequest(RequestInterface $request)
    {
        $this->request = $request;
    }

    /**
     * @return \Zend\Stdlib\RequestInterface
     */
    protected function getRequest()
    {
        return $this->request;
    }

}