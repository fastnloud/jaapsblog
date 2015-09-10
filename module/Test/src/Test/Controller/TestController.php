<?php

namespace Test\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Test\Form\TestForm;

/**
 * Class TestController
 * @package Test\Controller
 */
class TestController extends AbstractActionController
{

    /**
     * @var TestForm
     */
    protected $testForm;

    /**
     * @return ViewModel
     */
    public function testAction()
    {
        $viewModel = new ViewModel();
        $viewModel->setTerminal(true);

        $form    = $this->getTestForm();
        $isValid = false;

        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());

            if ($isValid = $form->isValid()) {

            }
        }

        var_dump($isValid);

        $viewModel->setVariable('form', $form);

        return $viewModel;
    }

    /**
     * @param \Test\Form\TestForm $testForm
     */
    public function setTestForm(TestForm $testForm)
    {
        $this->testForm = $testForm;
    }

    /**
     * @return \Test\Form\TestForm
     */
    protected function getTestForm()
    {
        return $this->testForm;
    }

}