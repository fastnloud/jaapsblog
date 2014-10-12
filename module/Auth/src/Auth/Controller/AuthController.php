<?php

namespace Auth\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\Authentication\AuthenticationService as AuthService;

class AuthController extends AbstractActionController
{

    /**
     * @var array
     */
    protected $config;

    /**
     * @var AuthService
     */
    protected $authService;

    /**
     * Authenticate User action.
     *
     * @return JsonModel
     */
    public function authUserAction()
    {
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();

            if (isset($data['user']) && isset($data['password'])) {
                $adapter = $this->getAuthService()
                         ->getAdapter();

                $adapter->setIdentityValue($data['user']);
                $adapter->setCredentialValue($data['password']);

                $result = $this->getAuthService()->authenticate();
                if ($result->isValid()) {
                    return new JsonModel(array(
                        'success' => true,
                        'msg'     => 'Authentication successful.'
                    ));
                }
            }
        }

        return new JsonModel(array(
            'success' => false,
            'msg'     => 'Authentication failed.'
        ));
    }

    /**
     * @param \Zend\Authentication\AuthenticationService $authService
     */
    public function setAuthService(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @return \Zend\Authentication\AuthenticationService
     */
    protected function getAuthService()
    {
        return $this->authService;
    }

}