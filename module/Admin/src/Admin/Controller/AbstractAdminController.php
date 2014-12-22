<?php

namespace Admin\Controller;

use Zend\Authentication\AuthenticationService as AuthService;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

abstract class AbstractAdminController extends AbstractActionController
{

    /**
     * @var AuthService
     */
    private $authService;

    /**
     * @return JsonModel
     */
    protected function authFailed()
    {
        $this->getResponse()
             ->setStatusCode(Response::STATUS_CODE_403);

        return new JsonModel(array(
            'success' => false
        ));
    }

    /**
     * @param \Zend\Authentication\AuthenticationService $authService
     */
    private function setAuthService($authService)
    {
        $this->authService = $authService;
    }

    /**
     * @return \Zend\Authentication\AuthenticationService
     */
    protected function getAuthService()
    {
        if (!$this->authService) {
            $this->setAuthService($this->getServiceLocator()->get('AuthService'));
        }

        return $this->authService;
    }

}