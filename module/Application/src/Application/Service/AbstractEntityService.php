<?php

namespace Application\Service;

use Application\Entity\AbstractEntity;
use Application\Entity\Exception\EntityException;
use Doctrine\Common\Util\Debug;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use Zend\Stdlib\RequestInterface;
use Zend\Form\FormElementManager;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\ServiceLocatorInterface;
use Application\Validator\XCrfToken;

/**
 * Class AbstractEntityService
 * @package Application\Service
 */
abstract class AbstractEntityService implements EntityServiceInterface
{

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var FormElementManager
     */
    protected $formElementManager;

    /**
     * @var XCrfToken
     */
    protected $xCrfTokenValidator;

    /**
     * @var int
     */
    protected $queryHydrator = Query::HYDRATE_OBJECT;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * Init.
     *
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->setEntityManager($serviceLocator->get('Doctrine\ORM\EntityManager'));
        $this->setFormElementManager($serviceLocator->get('FormElementManager'));
        $this->setXCrfTokenValidator($serviceLocator->get('ValidatorManager')->get('XCrfTokenValidator'));
        $this->setRequest($serviceLocator->get('Request'));
    }

    /**
     * Merge Entity with given JSON object. Note; the Entity will be detached
     * so validation can be applied.
     *
     * @param \stdClass $jsonObject
     * @param $entity
     * @return mixed
     */
    public function mergeEntityWithJsonObject($entity, \stdClass $jsonObject)
    {
        $this->getEntityManager()
             ->detach($entity);

        foreach ($jsonObject as $key => $value) {
            $var    = str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
            $setter = 'set' . $var;

            if (is_callable(array($entity, $setter))) {
                try {
                    $entity->$setter($value);
                } catch(EntityException $e) {
                    $getter     = 'get' . $var;
                    $repository = get_class($entity->$getter());

                    if (!empty($value)) {
                        $joinedEntity = $this->getEntityManager()
                                             ->getRepository($repository)
                                             ->find($value);

                        if ($joinedEntity) {
                            $entity->$setter($joinedEntity);
                        }
                    }
                }
            }
        }

        return $entity;
    }

    /**
     * Save or merge (update) detached entity.
     *
     * @param $entity
     * @param bool $merge
     * @return bool
     */
    public function saveEntity($entity, $merge = false)
    {
        if (true === $merge) {
            return (bool) $this->getEntityManager()
                               ->merge($entity);
        } else {
            $this->getEntityManager()
                 ->persist($entity);

            $this->getEntityManager()
                 ->flush();
        }

        return (bool) $entity;
    }

    /**
     * Destroy given entity.
     *
     * @param $entity
     * @return mixed
     */
    public function destroyEntity(AbstractEntity $entity)
    {
        $this->getEntityManager()
             ->remove($entity);

        return $entity;
    }

    /**
     * Validate given Entity object.
     *
     * @param AbstractEntity $entity
     * @return bool
     */
    public function validateEntity(AbstractEntity $entity)
    {
        $entityClassName = get_class($entity);

        try {
            $form = $this->getFormElementManager()
                         ->get($entityClassName);
        } catch (ServiceNotFoundException $e) {
            return false;
        }

        if (!$this->getXCrfTokenValidator()->isValid()) {
            return false;
        }

        $form->setData($entity->getArrayCopy());

        return $form->isValid();
    }

    /**
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    protected function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @param int $queryHydrator
     * @return $this
     */
    public function setQueryHydrator($queryHydrator)
    {
        $this->queryHydrator = (int) $queryHydrator;

        return $this;
    }

    /**
     * @return int
     */
    protected function getQueryHydrator()
    {
        return (int) $this->queryHydrator;
    }

    /**
     * @param \Zend\Form\FormElementManager $formElementManager
     */
    protected function setFormElementManager(FormElementManager $formElementManager)
    {
        $this->formElementManager = $formElementManager;
    }

    /**
     * @return \Zend\Form\FormElementManager
     */
    protected function getFormElementManager()
    {
        return $this->formElementManager;
    }

    /**
     * @param \Application\Validator\XCrfToken $xCrfTokenValidator
     */
    protected function setXCrfTokenValidator(XCrfToken $xCrfTokenValidator)
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

    /**
     * @param \Zend\Stdlib\RequestInterface $request
     */
    protected function setRequest(RequestInterface $request)
    {
        $this->request = $request;
    }

    /**
     * @return \Zend\Stdlib\RequestInterface
     */
    protected function getRequest()
    {
        return $this->request;
    }

}