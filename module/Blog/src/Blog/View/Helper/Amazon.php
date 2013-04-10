<?php

namespace Blog\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Blog\View\Helper\Amazon\ItemSearch;
use Blog\View\Helper\Amazon\ItemLookup;

class Amazon extends AbstractHelper
{

    protected $sm;

    function __construct($sm)
    {
        $this->sm = $sm;
    }

    /**
     * Returns a given date (string) as a nicely formatted
     * date.
     *
     * @param string $string
     * @return string date
     */
    public function __invoke($operation, array $options = array(), $cacheId)
    {
        $amazon = $this->sm->getServiceLocator()->get('Amazon');

        switch ($operation) {
            case 'ItemSearch':
                $view = new ItemSearch();
                break;
            case 'ItemLookup':
                $view = new ItemLookup();
                break;
        }

        if (isset($view)) {
            // Set view.
            $view->setView($this->getView());

            return $view->render($amazon, $options, $cacheId);
        }

        return false;
    }
}