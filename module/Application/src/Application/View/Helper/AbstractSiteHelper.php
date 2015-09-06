<?php

namespace Application\View\Helper;

use Zend\Form\View\Helper\AbstractHelper;
use Site\Service\SiteService;

/**
 * Class AbstractSiteHelper
 * @package Application\View\Helper
 */
abstract class AbstractSiteHelper extends AbstractHelper
{

    /**
     * @var SiteService
     */
    protected $siteService;

    /**
     * @param \Site\Service\SiteService $siteService
     */
    public function setSiteService(SiteService $siteService)
    {
        $this->siteService = $siteService;
    }

    /**
     * @return \Site\Service\SiteService
     */
    protected function getSiteService()
    {
        return $this->siteService;
    }

}