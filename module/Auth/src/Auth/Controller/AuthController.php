<?php

namespace Auth\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

class AuthController extends AbstractActionController
{

    public function authUserAction()
    {
        return new JsonModel();
    }

}