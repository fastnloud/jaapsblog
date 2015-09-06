<?php

namespace Application\View\Helper;

use Banner\Entity\Banner;

/**
 * Class BannersHelper
 * @package Application\View\Helper
 */
class BannersHelper extends AbstractSiteHelper
{

    /**
     * @return string
     */
    public function __invoke()
    {
        $html    = '';
        $banners = [];

        $site = $this->getSiteService()
                     ->getSite();

        if ($site->getBanner()) {
            foreach($site->getBanner() as $banner) {
                if ($banner instanceof Banner) {
                    $label   = $this->getView()->escapeHtml($banner->getTitle());
                    $content = $banner->getContent();

                    $banners[] = <<<BANNER
<aside class="content">
    <h2>$label</h2>
    <p>$content</p>
</aside>
BANNER;
                }
            }
        }

        $html = implode(PHP_EOL, $banners);

        return $html;
    }

}