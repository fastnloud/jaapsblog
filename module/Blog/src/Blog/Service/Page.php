<?php

namespace Blog\Service;

use Blog\Model\PageTable;
use Blog\Model\Page as PageModel;
use Zend\Navigation\Navigation;

class Page
{

    /**
     * @var bool
     */
    protected static $isHomepage = false;

    /**
     * @var Navigation
     */
    protected $navigation;

    /**
     * @var PageTable
     */
    protected $pageTable;

    /**
     * @param $urlString
     * @return bool
     */
    public function getPageByUrlString($urlString)
    {
        if (!$this->getNavigation()->findOneBy('url_string', $urlString)) {
            return false;
        }

        $page = $this->getPageTable()->getPageByUrlString(($urlString ? $urlString : 'home'));

        // flag as homepage
        if ('home' == $page->url_string) {
            $this->setIsHomepage(true);
        }

        return $page;
    }

    /**
     * @param \Blog\Model\PageTable $pageTable
     */
    public function setPageTable(PageTable $pageTable)
    {
        $this->pageTable = $pageTable;
    }

    /**
     * @return \Blog\Model\PageTable
     */
    protected function getPageTable()
    {
        return $this->pageTable;
    }

    /**
     * @param \Zend\Navigation\Navigation $navigation
     */
    public function setNavigation($navigation)
    {
        $this->navigation = $navigation;
    }

    /**
     * @return \Zend\Navigation\Navigation
     */
    protected function getNavigation()
    {
        return $this->navigation;
    }

    /**
     * @param bool $isHomepage
     */
    protected function setIsHomepage($isHomepage)
    {
        self::$isHomepage = (bool) $isHomepage;
    }

    /**
     * @return bool
     */
    public static function isHomepage()
    {
        return self::$isHomepage;
    }

}