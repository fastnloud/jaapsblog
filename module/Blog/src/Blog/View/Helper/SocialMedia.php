<?php

namespace Blog\View\Helper;
 
use Zend\View\Helper\AbstractHelper;
use Zend\Http\Request;
 
class SocialMedia extends AbstractHelper
{

    /**
     * @var \Zend\Http\Request
     */
    protected $request;

    /**
     * Available providers with social media
     * buttons.
     * 
     * @var array
     */
    protected $providers = array(
        'google' => array(
            'plus'
        )
    );
            
    /**
     * Returns a set of social media buttons.
     * 
     * @param string $providers
     * @return string
     */
    public function __invoke(array $providers)
    {
        $buttons = array();
        
        foreach ($providers as $provider => $methods) {
            if (array_key_exists($provider, $this->providers)) {
                $buttons[] = $this->create($provider, $methods);
            }
        }
        if ($this->request->getCookie() && $this->request->getCookie()->offsetExists('COOKIES')) {
            return '<div class="social-media">' . implode($buttons, PHP_EOL) . '</div>';
        }
    }
    
    /**
     * Create button.
     * 
     * @param string $provider
     * @param array $methods
     */
    protected function create($provider, $methods)
    {
        foreach ($methods as $method) {
            if (in_array($method, $this->providers[$provider])) {
                $func = $provider.ucFirst($method);
                return $this->$func();
            }
        }
        
        return false;
    }
    
    /**
     * Generate Google +1 button.
     * 
     * @return string
     */
    protected function googlePlus()
    {
        $script = <<<JS
(function() {
    var po = document.createElement('script'); 
    po.type = 'text/javascript'; 
    po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
JS;

        return '<div class="g-plusone"></div>'.$this->view->inlineScript()->setScript($script);
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