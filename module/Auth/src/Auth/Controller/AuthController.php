<?php

namespace Auth\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\Authentication\AuthenticationService as AuthService;
use Session\Service\SessionManager;
use Application\Validator\XCrfToken;
use User\Service\User as UserService;

/**
 * Class AuthController
 * @package Auth\Controller
 */
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
     * @var UserService
     */
    protected $userService;

    /**
     * @var SessionManager
     */
    protected $sessionManager;

    /**
     * @var XCrfToken
     */
    protected $xCrfTokenValidator;

    /**
     * @return JsonModel
     */
    public function pollAction()
    {
        return new JsonModel(array(
            'success' => $this->getAuthService()->hasIdentity()
        ));
    }

    /**
     * @return JsonModel
     */
    public function logoutAction()
    {
        $this->getAuthService()
             ->clearIdentity();

        return new JsonModel(array(
            'success' => true
        ));
    }

    /**
     * Authenticate User action.
     *
     * @return JsonModel
     */
    public function authUserAction()
    {
        if ($this->getRequest()->isPost()) {
            if (!$this->getXCrfTokenValidator()->isValid()) {
                return new JsonModel(array(
                    'success' => false,
                    'msg'     => 'Request could not be processed.'
                ));
            }

            $data = $this->getRequest()->getPost();

            if (isset($data['username']) && isset($data['password'])) {
                // add default user if none found
                if (!$this->getUserService()->hasUsers()) {
                    $this->getUserService()->addDefaultUser();
                }

                // authentication
                $adapter = $this->getAuthService()
                                ->getAdapter();

                $adapter->setIdentityValue($data['username']);
                $adapter->setCredentialValue($data['password']);

                $result = $this->getAuthService()->authenticate();
                if ($result->isValid()) {
                    // remember session + regenerate id
                    $this->getSessionManager()
                         ->rememberMe();

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

    /**
     * @param \User\Service\User $userService
     */
    public function setUserService(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @return \User\Service\User
     */
    protected function getUserService()
    {
        return $this->userService;
    }

    /**
     * @param \Session\Service\SessionManager $sessionManager
     */
    public function setSessionManager(SessionManager $sessionManager)
    {
        $this->sessionManager = $sessionManager;
    }

    /**
     * @return \Session\Service\SessionManager
     */
    protected function getSessionManager()
    {
        return $this->sessionManager;
    }

    /**
     * @param \Application\Validator\XCrfToken $xCrfTokenValidator
     */
    public function setXCrfTokenValidator(XCrfToken $xCrfTokenValidator)
    {
        $this->xCrfTokenValidator = $xCrfTokenValidator;
    }

    /**
     * @return \Application\Validator\XCrfToken
     */
    protected function getXCrfTokenValidator()
    {
        return $this->xCrfTokenValidator;
    }

}