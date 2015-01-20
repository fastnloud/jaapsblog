<?php

namespace Admin\Controller;

use Doctrine\ORM\Query;
use Site\Service\Site as SiteService;
use Zend\View\Model\JsonModel;

class SiteController extends AbstractAdminController
{

    /**
     * @var SiteService
     */
    protected $siteService;

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

        $data = $this->getSiteService()
                     ->setQueryHydrator(Query::HYDRATE_ARRAY)
                     ->getSites();

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
            $entity = $this->getSiteService()
                           ->mergeEntityWithJsonObject(new \Site\Entity\Site(), $jsonObject);

            if ($this->getSiteService()->validateEntity($entity)) {
                $success = $this->getSiteService()
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
            $site = $this->getSiteService()
                         ->getSite($jsonObject->id);

            if ($site) {
                $entity = $this->getSiteService()
                               ->mergeEntityWithJsonObject($site, $jsonObject);

                if ($this->getSiteService()->validateEntity($entity)) {
                    $success = $this->getSiteService()
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
                    $entity  = $this->getSiteService()
                                    ->getSite($jsonObject->id);

                    if ($entity) {
                        $this->getSiteService()
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
     * @param \Site\Service\Site $siteService
     */
    public function setSiteService(SiteService $siteService)
    {
        $this->siteService = $siteService;
    }

    /**
     * @return \Site\Service\Site
     */
    protected function getSiteService()
    {
        return $this->siteService;
    }

}