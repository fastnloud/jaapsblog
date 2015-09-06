<?php

namespace Admin\Controller;

use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Query;
use Zend\Authentication\AuthenticationService;
use Application\Service\AbstractEntityService;
use Application\Entity\AbstractEntity;
use Zend\Http\Header\SetCookie;
use Zend\Http\Response;
use Zend\Math\Rand;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\View\Model\JsonModel;

class AdminController extends AbstractActionController
{

    /**
     * @var array
     */
    protected $config;

    /**
     * @var array
     */
    protected $tables;

    /**
     * @var AbstractEntity
     */
    protected $entity;

    /**
     * @var AuthenticationService
     */
    protected $authService;

    /**
     * @var AbstractEntityService
     */
    protected $entityService;

    /**
     * Set config admin tables.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->setConfig($config);

        if (isset($config['admin']) && isset($config['admin']['tables'])) {
            $this->setTables($config['admin']['tables']);
        }
    }

    /**
     * @return false
     */
    public function indexAction()
    {
        $cookie = SetCookie::fromString("Set-Cookie: Csrf-Token={$this->generateCsrfToken()}; Path=/");

        $this->getResponse()
             ->getHeaders()
             ->addHeader($cookie);

        $this->layout('layout/admin');

        return false;
    }

    /**
     * Generate Csrf-Token random hash.
     *
     * @return string
     */
    protected function generateCsrfToken()
    {
        return md5(Rand::getBytes(32));
    }

    /**
     * Fetch and validate table data.
     *
     * @return bool
     */
    protected function fetchTableData()
    {
        $tables = $this->getTables();
        $table  = $this->params()->fromRoute('table');
        $action = $this->params()->fromRoute('action');

        // check if table exists in config
        if (isset($tables[$table])) {

            // defined actions
            if (isset($tables[$table]['actions'])) {
                $actions = $tables[$table]['actions'];

                // validate action
                if (in_array($action, $actions)) {

                    // check for a valid service
                    if (isset($tables[$table]['service'])) {
                        try {
                            $service = $this->getServiceLocator()
                                            ->get($tables[$table]['service']);

                            if ($service instanceof AbstractEntityService) {
                                $this->setEntityService($service);

                                // if service is found and set fetch entity
                                if (isset($tables[$table]['entity'])) {
                                    $entity = $tables[$table]['entity'];

                                    if (class_exists($entity)) {
                                        $class = new $entity();

                                        // only if entity is entity continue
                                        if ($class instanceof AbstractEntity) {
                                            $this->setEntity($class);

                                            return true;
                                        }
                                    }
                                }
                            } else {
                                return false;
                            }
                        } catch (ServiceNotFoundException $e) {
                            return false;
                        }
                    }
                }
            }
        }

        return false;
    }

    /**
     * Read.
     *
     * @return JsonModel
     */
    public function readAction()
    {
        if (!$this->getAuthService()->hasIdentity()) {
            return $this->authFailed();
        }

        if (!$this->fetchTableData()) {
            return $this->tableDataError();
        }

        $data = $this->getEntityService()
                     ->setQueryHydrator(Query::HYDRATE_ARRAY)
                     ->fetchEntities();

        return new JsonModel(array(
            'data' => $data
        ));
    }

    /**
     * Create.
     *
     * @return JsonModel
     */
    public function createAction()
    {
        if (!$this->getAuthService()->hasIdentity()) {
            return $this->authFailed();
        }

        if (!$this->fetchTableData()) {
            return $this->tableDataError();
        }

        $success    = false;
        $jsonObject = json_decode($this->params()->fromPost('data'));

        if ($jsonObject) {
            $entity = $this->getEntityService()
                           ->mergeEntityWithJsonObject($this->getEntity(), $jsonObject);

            if ($this->getEntityService()->validateEntity($entity)) {
                $success = $this->getEntityService()
                                ->saveEntity($entity);

                if (false !== $success) {
                    return new JsonModel(array(
                        'success'   => $success,
                        'id'        => $entity->getId()
                    ));
                }
            }
        }

        return new JsonModel(array(
            'success' => $success
        ));
    }

    /**
     * Update.
     *
     * @return JsonModel
     */
    public function updateAction()
    {
        if (!$this->getAuthService()->hasIdentity()) {
            return $this->authFailed();
        }

        if (!$this->fetchTableData()) {
            return $this->tableDataError();
        }

        $success    = false;
        $jsonObject = json_decode($this->params()->fromPost('data'));

        if (isset($jsonObject->id)) {
            try {
                $record = $this->getEntityService()
                               ->fetchEntity($jsonObject->id);

                if ($record) {
                    $entity = $this->getEntityService()
                                   ->mergeEntityWithJsonObject($record, $jsonObject);

                    if ($this->getEntityService()->validateEntity($entity)) {
                        $success = $this->getEntityService()
                                        ->saveEntity($entity, true);
                    }
                }
            } catch (NoResultException $e) {
                $success = false;
            }
        }

        return new JsonModel(array(
            'success' => $success
        ));
    }

    /**
     * Destroy.
     *
     * @return JsonModel
     */
    public function destroyAction()
    {
        if (!$this->getAuthService()->hasIdentity()) {
            return $this->authFailed();
        }

        if (!$this->fetchTableData()) {
            return $this->tableDataError();
        }

        $success              = false;
        $jsonObject           = json_decode($this->params()->fromPost('data'));
        $jsonObjectCollection = array();

        if (isset($jsonObject->id)) {
            $jsonObjectCollection[] = $jsonObject;
        } elseif (is_array($jsonObject)) {
            $jsonObjectCollection = $jsonObject;
        }

        if (!empty($jsonObjectCollection)) {
            foreach ($jsonObjectCollection as $jsonObject) {
                if (isset($jsonObject->id)) {
                    try {
                        $entity = $this->getEntityService()
                                       ->fetchEntity($jsonObject->id);

                        if ($entity) {
                            $this->getEntityService()
                                 ->destroyEntity($entity);
                        }
                    } catch (NoResultException $e) {
                        $success = false;
                        break;
                    }

                    $success = true;
                }
            }
        }

        return new JsonModel(array(
            'success' => $success
        ));
    }

    /**
     * @return JsonModel
     */
    protected function authFailed()
    {
        $this->getResponse()
             ->setStatusCode(Response::STATUS_CODE_403);

        return new JsonModel(array(
            'success' => false,
            'msg'     => 'Authentication failed.'
        ));
    }

    /**
     * @return JsonModel
     */
    protected function tableDataError()
    {
        $this->getResponse()
             ->setStatusCode(Response::STATUS_CODE_422);

        return new JsonModel(array(
            'success' => false,
            'msg'     => 'Table data error.'
        ));
    }

    /**
     * @param array $config
     */
    protected function setConfig($config)
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

    /**
     * @param array $tables
     */
    protected function setTables(array $tables)
    {
        $this->tables = $tables;
    }

    /**
     * @return array
     */
    protected function getTables()
    {
        return $this->tables;
    }

    /**
     * @param \Application\Entity\AbstractEntity $entity
     */
    protected function setEntity(AbstractEntity $entity)
    {
        $this->entity = $entity;
    }

    /**
     * @return \Application\Entity\AbstractEntity
     */
    protected function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param \Application\Service\AbstractEntityService $entityService
     */
    protected function setEntityService(AbstractEntityService $entityService)
    {
        $this->entityService = $entityService;
    }

    /**
     * @return \Application\Service\AbstractEntityService
     */
    protected function getEntityService()
    {
        return $this->entityService;
    }

    /**
     * @param \Zend\Authentication\AuthenticationService $authService
     */
    public function setAuthService(AuthenticationService $authService)
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