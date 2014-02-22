<?php

namespace Blog\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Http\Header\SetCookie as Cookie;
use Zend\Http\Request;
use Zend\Http\Response;

class Cookies extends AbstractHelper
{

    /**
     * @var \Zend\Http\Request
     */
    protected $request;

    /**
     * @var \Zend\Http\Response
     */
    protected $response;

    /**
     * Stupid Cookie check because we have to.
     *
     * @return string
     */
    public function __invoke()
    {
        // this bit will remove the already set cookies
        if ($this->getRequest()->getCookie() && !$this->getRequest()->getCookie()->offsetExists('COOKIES')) {
            foreach ($this->getRequest()->getCookie() as $name => $value) {
                $this->unsetCookie($name);
            }
        }

        // cookies allowed
        if ($this->getRequest()->getQuery('cookies')) {
            // set cookie
            $this->setCookie(true);

            // fetch uri
            $uri = $this->getRequest()->getUri();

            // redirect
            $response = $this->getResponse();
            $response->getHeaders()->addHeaderLine('Location', $uri->getScheme() . '://' . $uri->getHost() . $uri->getPath());
            $response->setStatusCode(302);
            $response->sendHeaders();
            exit;
        }
        // render only if user has not yet agreed to the use of cookies
        elseif ((!$this->getRequest()->getCookie() || !$this->getRequest()->getCookie()->offsetExists('COOKIES')) && !preg_match('/\/cookies\.html$/i', $this->getRequest()->getUri()->getPath())) {
            return '<div id="cookies-overlay"></div>' . PHP_EOL
                 . '    <div id="cookies">' . PHP_EOL
                 . '        <h1>Cookies in use</h1>' . PHP_EOL
                 . '        <p>By continuing to use <strong>Jaapsblog.nl</strong> you will be agreeing to the website ' . PHP_EOL
                 . '        <a href="/cookies.html">Use Of Cookies</a> while using the website.</p>' . PHP_EOL
                 . '        <p><a rel="nofollow" href="?cookies=1">Continue</a></p>' . PHP_EOL
                 . '</div>'  . PHP_EOL;
        }
    }

    /**
     * Set Cookie "COOKIE" and add to header.
     *
     * @param $value
     * @return void
     */
    protected function setCookie($value)
    {
        $cookie = new Cookie();

        $cookie->setName('COOKIES');
        $cookie->setValue($value);
        $cookie->setPath('/');
        $cookie->setExpires(time()+60*60*24*365); // 1 year
        $cookie->setDomain(preg_replace('/^[a-z]{0,3}\./iU', '', $this->getRequest()->getUri()->getHost()));

        $this->getResponse()->getHeaders()->addHeader($cookie);
    }

    /**
     * Unset Cookie and add to header.
     *
     * @param $name
     * @return void
     */
    protected function unsetCookie($name)
    {
        $cookie = new Cookie();

        $cookie->setName($name);
        $cookie->setPath('/');
        $cookie->setExpires(time()-9999);
        $cookie->setDomain(preg_replace('/^[a-z]{0,3}\./iU', '', $this->getRequest()->getUri()->getHost()));

        $this->getResponse()->getHeaders()->addHeader($cookie);
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
     * @param \Zend\Http\Response $response
     */
    public function setResponse(Response $response)
    {
        $this->response = $response;
    }

    /**
     * @return \Zend\Http\Response
     */
    protected function getResponse()
    {
        return $this->response;
    }

}