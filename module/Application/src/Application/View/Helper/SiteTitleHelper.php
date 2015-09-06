<?php

namespace Application\View\Helper;

/**
 * Class SiteTitleHelper
 * @package Application\View\Helper
 */
class SiteTitleHelper extends AbstractSiteHelper
{

    /**
     * @return string
     */
    public function __invoke()
    {
        $site = $this->getSiteService()
                     ->getSite();

        return $site->getTitle();
    }

}