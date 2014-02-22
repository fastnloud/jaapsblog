<?php

namespace Blog\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Http\Request;

class Analytics extends AbstractHelper
{

    /**
     * @var array
     */
    protected $config;

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
        $config = $this->getConfig();

        if ($config['google']['analytics']['account']) {
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

            if ($this->request->getCookie() && $this->request->getCookie()->offsetExists('COOKIES')) {
                return $this->view->inlineScript()->setScript($script);
            }
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

    /**
     * @param array $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }

    /**
     * @return array
     */
    protected function getConfig()
    {
        return $this->config;
    }

}