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
     * Fetch 'active' site by domain.
     *
     * @return Site
     * @throws \Exception
     */
    public function getSite()
    {
        $host = $this->getRequest()
                     ->getUri()
                     ->getHost();

        $sites = $this->fetchEntities();

        foreach ($sites as $site) {
            $domains = array_map('trim', explode(',', $site->getDomain()));

            foreach ($domains as $domain) {
                if ($host == $domain) {
                    return $this->fetchSite($site->getId());
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

}