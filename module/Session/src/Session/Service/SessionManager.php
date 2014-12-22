<?php

namespace Session\Service;

use Zend\Session\Container;
use Zend\Http\Request;
use Zend\Session\Exception\RuntimeException;

class SessionManager extends \Zend\Session\SessionManager
{

    /**
     * @var array
     */
    protected $sessionConfig;

    /**
     * @var Request
     */
    protected $request;

    /**
     * Initialize manager and set as default manager.
     *
     * @return void
     */
    public function init()
    {
        Container::setDefaultManager($this);
    }

    /**
     * Gracefully start session.
     *
     * @return void
     * @throws RuntimeException
     */
    public function graceful()
    {
        $this->start();

        $sessionConfig = $this->getSessionConfig();
        $container     = new Container('init');

        if (!isset($container->init)) {
            $this->regenerateId(true);
            $container->init = true;

            if (isset($sessionConfig['validators'])) {
                $this->attachValidators($container, $sessionConfig['validators']);
            }
        }
    }

    /**
     * Attach validators.
     *
     * @param Container $container
     * @param array $validators
     * @return void
     */
    protected function attachValidators(Container $container, array $validators)
    {
        $request = $this->getRequest();

        foreach ($validators as $validator) {
            switch ($validator) {
                case 'Zend\Session\Validator\HttpUserAgent':
                    $container->httpUserAgent = $request->getServer()->get('HTTP_USER_AGENT');
                    $validator = new $validator($container->httpUserAgent);
                    break;
                case 'Zend\Session\Validator\RemoteAddr':
                    $container->remoteAddr = $request->getServer()->get('REMOTE_ADDR');
                    $validator = new $validator($container->remoteAddr);
                    break;
                default:
                    $validator = new $validator();
            }

            $this->getValidatorChain()
                 ->attach('session.validate', array($validator, 'isValid'));
        }
    }

    /**
     * @param array $sessionConfig
     */
    public function setSessionConfig(array $sessionConfig)
    {
        $this->sessionConfig = $sessionConfig;
    }

    /**
     * @return array
     */
    protected function getSessionConfig()
    {
        return $this->sessionConfig;
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