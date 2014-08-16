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
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', '{$config['google']['analytics']['account']}', 'auto');
ga('send', 'pageview');
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