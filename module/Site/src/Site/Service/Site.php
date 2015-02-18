<?php

namespace Site\Service;

use Site\Entity\Site as SiteEntity;
use Doctrine\ORM\NoResultException;
use Zend\Http\Request;
use Zend\Stdlib\RequestInterface;
use Application\Entity\AbstractEntityService;

/**
 * Class Site
 * @package Site\Service
 */
class Site extends AbstractEntityService
{

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var SiteEntity
     */
    private static $activeSite;

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
                $site = new SiteEntity();
                $site->setTitle('Undefined App');
            }

            $this->setActiveSite($site);
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
     * @param SiteEntity $activeSite
     */
    private function setActiveSite(SiteEntity $activeSite)
    {
        self::$activeSite = $activeSite;
    }

    /**
     * @return SiteEntity
     */
    public static function getActiveSite()
    {
        return self::$activeSite;
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