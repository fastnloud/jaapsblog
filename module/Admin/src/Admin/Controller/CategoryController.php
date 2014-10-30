<?php

namespace Admin\Controller;

use Doctrine\ORM\Query;
use Category\Service\Category as CategoryService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

class CategoryController extends AbstractActionController
{

    /**
     * @var CategoryService
     */
    protected $categoryService;

    /**
     * Read.
     *
     * @return array|JsonModel
     */
    public function readAction()
    {
        $data = $this->getCategoryService()
                     ->setQueryHydrator(Query::HYDRATE_ARRAY)
                     ->getCategory();

        return new JsonModel(array(
            'data' => $data
        ));
    }

    /**
     * @param \Category\Service\Category $categoryService
     */
    public function setCategoryService(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * @return \Category\Service\Category
     */
    protected function getCategoryService()
    {
        return $this->categoryService;
    }

}