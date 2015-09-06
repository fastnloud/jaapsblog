<?php

namespace Application\View\Helper;

/**
 * Class SocialNetworksHelper
 * @package Application\View\Helper
 */
class SocialNetworksHelper extends AbstractSiteHelper
{

    /**
     * @return string
     */
    public function __invoke()
    {
        $html = '';
        $site = $this->getSiteService()
                     ->getSite();

        $linkedinHref   = $this->getView()->escapeHtmlAttr($site->getLinkedinUrl());
        $googlePlusHref = $this->getView()->escapeHtmlAttr($site->getGooglePlusUrl());
        $facebookHref   = $this->getView()->escapeHtmlAttr($site->getFacebookUrl());

        if ($linkedinHref) {
            $html .= "<a href=\"$linkedinHref\"><i class=\"fa fa-linkedin\"></i></a>";
        }

        if ($googlePlusHref) {
            $html .= "<a href=\"$googlePlusHref\"><i class=\"fa fa-google-plus\"></i></a>";
        }

        if ($facebookHref) {
            $html .= "<a href=\"$facebookHref\"><i class=\"fa fa-facebook\"></i></a>";
        }

        $html = <<<SOCIALNETWORKS
<div class="social-networks">
    $html
</div>
SOCIALNETWORKS;

        return $html;
    }

}