<?php

namespace Auth\Controller;

use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\Digest;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

use Auth\Model\Auth;

class AuthController extends AbstractActionController
{

    /**
     * @var array
     */
    protected $config;

    /**
     * Build and handle login form.
     * 
     * @return multitype:\Auth\Controller\AuthForm
     */
    public function loginAction()
    {
        $form    = new \Zend\Form\Form();
        $request = $this->getRequest();
        $success = false;

        if ($request->isPost()) {
            $auth = new Auth();
            $form->setInputFilter($auth->getInputFilter());
            $form->setData($request->getPost());
        
            if ($form->isValid()) {
                if ($this->authenticate($form->getData())) {
                    $success = true;
                }
            } elseif(true === AUTHENTICATED) {
                $success = true;
            }
        }

        return new JsonModel(array(
            'success' => $success
        ));
    }
    
    /**
     * Kill session and redirect to homepage.
     * 
     * @return false;
     */
    public function logoutAction()
    {
        $auth = new AuthenticationService();
        $auth->clearIdentity();

        return new JsonModel(array(
            'success' => true
        ));
    }
    
    /**
     * Auhtenticate user input.
     * 
     * @param array $data
     * @return boolean
     */
    protected function authenticate($data)
    {
        $config   = $this->getConfig();
        $auth     = new AuthenticationService();
        $adapter  = new Digest($config['auth']['filename'], $config['auth']['realm'], $data['username'], $data['password']);
        
        $result = $auth->authenticate($adapter);
        if ($result->isValid()) {
            return true;
        }
        
        return false;
    }

    /**
     * @param array $config
     */
    public function setConfig(array $config)
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
