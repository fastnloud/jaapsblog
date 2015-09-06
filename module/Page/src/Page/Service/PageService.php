<?php

namespace Page\Service;

use Application\Service\AbstractEntityService;
use Site\Entity\Site;

/**
 * Class PageService
 * @package Page\Service
 */
class PageService extends AbstractEntityService
{

    /**
     * @return mixed
     */
    public function fetchEntities()
    {
        return $this->getEntityManager()
                    ->getRepository('Page\Entity\Page')
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
                    ->getRepository('Page\Entity\Page')
                    ->setQueryHydrator($this->getQueryHydrator())
                    ->fetchEntity($id);
    }

    /**
     * @param Site $site
     * @return mixed
     */
    public function fetchPages(Site $site)
    {
        return $this->getEntityManager()
                    ->getRepository('Page\Entity\Page')
                    ->setQueryHydrator($this->getQueryHydrator())
                    ->fetchPages($site);
    }

    /**
     * @param $slug
     * @param Site $site
     * @return mixed
     */
    public function fetchPageBySlug($slug, Site $site)
    {
        return $this->getEntityManager()
                    ->getRepository('Page\Entity\Page')
                    ->setQueryHydrator($this->getQueryHydrator())
                    ->fetchPageBySlug($slug, $site);
    }

    /**
     * @param $route
     * @param Site $site
     * @return mixed
     */
    public function fetchPageByRoute($route, Site $site)
    {
        return $this->getEntityManager()
                    ->getRepository('Page\Entity\Page')
                    ->setQueryHydrator($this->getQueryHydrator())
                    ->fetchPageByRoute($route, $site);
    }

}