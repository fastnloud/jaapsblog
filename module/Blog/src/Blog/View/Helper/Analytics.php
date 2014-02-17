<?php

namespace Blog\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Http\Request;

class Analytics extends AbstractHelper
{

    /**
     * @var \Zend\Http\Request
     */
    protected $request;

    /**
     * Print Google Analytics code.
     *
     * @return string
     */
    public function __invoke()
    {
        $script = <<<JS
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-35946656-1']);
_gaq.push(['_trackPageview']);

(function() {
var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
JS;

        if ('development' != getenv('application_env') && $this->request->getCookie() && $this->request->getCookie()->offsetExists('COOKIES')) {
            return $this->view->inlineScript()->setScript($script);
        }

        return false;
    }

    /**
     * @param \Zend\Http\Request $request
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return \Zend\Http\Request
     */
    protected function getRequest()
    {
        return $this->request;
    }

}