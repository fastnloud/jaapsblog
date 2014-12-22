<?php

namespace Admin\Controller;

use Doctrine\ORM\Query;
use Blog\Service\Blog as BlogService;
use Zend\View\Model\JsonModel;

class BlogController extends AbstractAdminController
{

    /**
     * @var BlogService
     */
    protected $blogService;

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

        $data = $this->getBlogService()
                     ->setQueryHydrator(Query::HYDRATE_ARRAY)
                     ->getAllBlogItems();

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

        $success    = false;
        $jsonObject = json_decode($this->params()->fromPost('data'));

        if ($jsonObject) {
            $entity = $this->getBlogService()
                           ->mergeEntityWithJsonObject(new \Blog\Entity\Blog(), $jsonObject);

            if ($this->getBlogService()->validateEntity($entity)) {
                $success = $this->getBlogService()
                                ->saveEntity($entity);
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

        $success    = false;
        $jsonObject = json_decode($this->params()->fromPost('data'));

        if (isset($jsonObject->id)) {
            $blogItem = $this->getBlogService()
                             ->getBlogItem($jsonObject->id);

            if ($blogItem) {
                $entity = $this->getBlogService()
                               ->mergeEntityWithJsonObject($blogItem, $jsonObject);

                if ($this->getBlogService()->validateEntity($entity)) {
                    $success = $this->getBlogService()
                                    ->saveEntity($entity, true);
                }
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

        $success              = false;;
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
                    $entity  = $this->getBlogService()
                                    ->getBlogItem($jsonObject->id);

                    if ($entity) {
                        $this->getBlogService()
                             ->deleteEntity($entity);
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
     * @param \Blog\Service\Blog $blogService
     */
    public function setBlogService(BlogService $blogService)
    {
        $this->blogService = $blogService;
    }

    /**
     * @return \Blog\Service\Blog
     */
    protected function getBlogService()
    {
        return $this->blogService;
    }

}