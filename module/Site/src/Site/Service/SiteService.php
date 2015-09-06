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
     * @var Site
     */
    protected $activeSite;

    /**
     * Fetch 'active' site by domain.
     *
     * @return Site
     * @throws \Exception
     */
    public function getSite()
    {
        if ($this->getActiveSite()) {
            return $this->getActiveSite();
        }

        $host = $this->getRequest()
                     ->getUri()
                     ->getHost();

        $sites = $this->fetchEntities();

        foreach ($sites as $site) {
            $domains = array_map('trim', explode(',', $site->getDomain()));

            foreach ($domains as $domain) {
                if ($host == $domain) {
                    $activeSite = $this->fetchSite($site->getId());
                    $this->setActiveSite($activeSite);

                    return $activeSite;
                }
            }
        }

        throw new NoResultException('No site found');
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
     * @param $id
     * @return mixed
     */
    protected function fetchSite($id)
    {
        return $this->getEntityManager()
                    ->getRepository('Site\Entity\Site')
                    ->setQueryHydrator($this->getQueryHydrator())
                    ->fetchSite($id);
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

    /**
     * @param \Site\Entity\Site $activeSite
     */
    protected function setActiveSite(Site $activeSite)
    {
        $this->activeSite = $activeSite;
    }

    /**
     * @return \Site\Entity\Site
     */
    protected function getActiveSite()
    {
        return $this->activeSite;
    }

}