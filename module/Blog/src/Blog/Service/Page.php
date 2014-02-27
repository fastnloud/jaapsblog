<?php

namespace Blog\Service;

use Blog\Model\PageTable;
use Zend\Navigation\Navigation;

class Page extends Service
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
     * Get pages.
     *
     * @return array|null|\Zend\Db\ResultSet\ResultSetInterface
     */
    public function getPages()
    {
        $pages = $this->getPageTable()->getPages();

        if ('JsonArray' == $this->getReturnType()) {
            return $this->returnAsJsonArray($pages);
        }

        return $pages;
    }

    /**
     * Get page by URL String.
     *
     * @param $urlString
     * @return bool|mixed
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
     * Edit page (validating POST data).
     *
     * @return array
     */
    public function save($model)
    {
        $data = $this->encodeAndValidateJsonData($model);

        if (false !== $data) {
            $result = (bool) $this->getPageTable()->save($data);
        }

        return $this->returnAsJsonArray(isset($result) ? $result : false);
    }

    /**
     * Delete page (validating POST data).
     *
     * @return array
     */
    public function remove()
    {
        $data = $this->encodeAndValidateJsonData();

        if (false !== $data) {
            $result = (bool) $this->getPageTable()->remove($data['id']);
        }

        return $this->returnAsJsonArray(isset($result) ? $result : false);
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