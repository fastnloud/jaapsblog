<?php

namespace Admin\Controller;

use Doctrine\ORM\Query;
use Page\Service\Page as PageService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

class PageController extends AbstractActionController
{

    /**
     * @var PageService
     */
    protected $pageService;

    /**
     * Read.
     *
     * @return JsonModel
     */
    public function readAction()
    {
        $data = $this->getPageService()
                     ->setQueryHydrator(Query::HYDRATE_ARRAY)
                     ->getAllPages();

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
        $success    = false;
        $jsonObject = json_decode($this->params()->fromPost('data'));

        if ($jsonObject) {
            $entity = $this->getPageService()
                           ->mergeEntityWithJsonObject(new \Page\Entity\Page(), $jsonObject);

            if ($this->getPageService()->validateEntity($entity)) {
                $success = $this->getPageService()
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
        $success    = false;
        $jsonObject = json_decode($this->params()->fromPost('data'));

        if (isset($jsonObject->id)) {
            $page = $this->getPageService()
                         ->getPage($jsonObject->id);

            if ($page) {
                $entity = $this->getPageService()
                               ->mergeEntityWithJsonObject($page, $jsonObject);

                if ($this->getPageService()->validateEntity($entity)) {
                    $success = $this->getPageService()
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
                    $entity  = $this->getPageService()
                                    ->getPage($jsonObject->id);

                    if ($entity) {
                        $this->getPageService()
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
     * @param \Page\Service\Page $pageService
     */
    public function setPageService(PageService $pageService)
    {
        $this->pageService = $pageService;
    }

    /**
     * @return \Page\Service\Page
     */
    protected  function getPageService()
    {
        return $this->pageService;
    }

}