<?php

namespace Application\View\Helper;

use Footer\Entity\Footer;
use Zend\Form\View\Helper\AbstractHelper;
use Site\Service\SiteService;

class FooterHelper extends AbstractHelper
{

    /**
     * @var SiteService
     */
    protected $siteService;

    /**
     * @return string
     */
    public function __invoke()
    {
        $list          = '';
        $footerColumns = [];

        $site = $this->getSiteService()
                     ->getSite();

        if ($site->getFooter()) {
            foreach($site->getFooter() as $footer) {
                if ($footer instanceof Footer) {
                    $href  = $this->getView()->escapeHtmlAttr($footer->getHref());
                    $label = $this->getView()->escapeHtml($footer->getLabel());

                    $footerColumns[$footer->getFooterColumn()][] = "<li><a href=\"$href\">$label</a></li>";
                }
            }
        }

        foreach ($footerColumns as $footerColumn) {
            $list .= '<ul>' . implode('', $footerColumn) . '</ul>';
        }

        return $list;
    }

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