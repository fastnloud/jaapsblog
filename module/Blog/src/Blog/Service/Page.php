<?php

namespace Blog\Service;

use Blog\Model\PageTable;
use Zend\Navigation\Navigation;

class Page extends Service
{

    /**
     * @var string
     */
    protected static $version = '1';

    /**
     * @var bool
     */
    protected static $hasPage = false;

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
     * Init and set version param.
     *
     * @param $version
     */
    public function __construct($version)
    {
        self::setVersion($version);
    }

    /**
     * Get pages.
     *
     * @return array|null|\Zend\Db\ResultSet\ResultSetInterface
     */
    public function getPages()
    {
        $result = $this->getPageTable()->fetchAll();

        if ('JsonArray' == $this->getReturnType()) {
            return $this->returnAsJsonArray($result);
        }

        return $result;
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

        $result = $this->getPageTable()->fetchByUrlString(($urlString ? $urlString : 'home'));

        // flag as homepage
        if ($result && 'home' == $result->url_string) {
            $this->setIsHomepage(true);
        }

        // flag has page
        $this->setHasPage(true);

        return $result;
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

    /**
     * @param boolean $hasPage
     */
    public static function setHasPage($hasPage)
    {
        self::$hasPage = (bool) $hasPage;
    }

    /**
     * @return boolean
     */
    public static function hasPage()
    {
        return self::$hasPage;
    }

    /**
     * @param string $version
     */
    public static function setVersion($version)
    {
        self::$version = $version;
    }

    /**
     * @return string
     */
    public static function version()
    {
        return self::$version;
    }

}