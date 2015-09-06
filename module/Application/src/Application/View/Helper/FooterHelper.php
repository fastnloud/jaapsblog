<?php

namespace Application\View\Helper;

use Footer\Entity\Footer;
use Site\Service\SiteService;

class FooterHelper extends AbstractSiteHelper
{

    /**
     * @return string
     */
    public function __invoke()
    {
        $html          = '';
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
            $html .= '<ul>' . implode('', $footerColumn) . '</ul>';
        }

        return $html;
    }

}