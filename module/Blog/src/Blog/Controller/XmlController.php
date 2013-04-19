<?php

namespace Blog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class XmlController extends AbstractActionController
{
    public function sitemapAction()
    {
        $this->response->getHeaders()->addHeaderLine('Content-Type', 'text/xml');

        $viewModel = new ViewModel();
        $viewModel->setTerminal(true);

        return $viewModel;
    }
}