<?php

namespace Blog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class XmlController extends AbstractActionController
{

    protected $blogTable;

    /**
     * Generate sitemap.
     *
     * @return \Zend\View\Model\ViewModel
     */
    public function sitemapAction()
    {
        $sm = $this->getEvent()->getApplication()->getServiceManager();

        // Set correct headers.
        $this->response->getHeaders()->addHeaderLine('Content-Type', 'text/xml');

        // Beginning of the XML sitemap document.
        $xml = new \SimpleXMLElement('<urlset/>');
        $xml->addAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

        // Add children.
        $xml = $this->sitemapFetchStatics($xml, $sm);
        $xml = $this->sitemapFetchBlogItems($xml, $sm);

        // Disable layout and set xml variable.
        $viewModel = new ViewModel();
        $viewModel->setTerminal(true);
        $viewModel->xml = $xml;

        return $viewModel;
    }

    /**
     * Add static child items to XML document.
     *
     * @param \SimpleXMLElement $xml
     * @param \Zend\ServiceManager\ServiceManager $sm
     * @return \SimpleXMLElement
     */
    protected function sitemapFetchStatics(\SimpleXMLElement $xml, \Zend\ServiceManager\ServiceManager $sm)
    {
        $urlHelper = $sm->get('viewhelpermanager')->get('Url');

        $child = $xml->addChild('url');
        $child->addChild('loc',"{$urlHelper('home', array(), array('force_canonical' => true))}");

        $child = $xml->addChild('url');
        $child->addChild('loc',"{$urlHelper('page', array('page' => 'cookies.html'), array('force_canonical' => true))}");

        $child = $xml->addChild('url');
        $child->addChild('loc',"{$urlHelper('page', array('page' => 'blog'), array('force_canonical' => true))}");

        return $xml;
    }

    /**
     * Add blog child items to XML document.
     *
     * @param \SimpleXMLElement $xml
     * @param \Zend\ServiceManager\ServiceManager $sm
     * @return \SimpleXMLElement
     */
    protected function sitemapFetchBlogItems(\SimpleXMLElement $xml, \Zend\ServiceManager\ServiceManager $sm)
    {
        $urlHelper = $sm->get('viewhelpermanager')->get('Url');
        $urlStringHelper = $sm->get('viewhelpermanager')->get('UrlString');

        $items = $this->getBlogTable()->getIndex();

        foreach ($items as $blog) {
            $child = $xml->addChild('url');
            $child->addChild('loc',"{$urlHelper('blog', array(
                'action' => 'view',
                'id'     => $blog->id,
                'title'  => $urlStringHelper($blog->title)
            ), array(
                'force_canonical' => true
            ))}");
            $child->addChild('lastmod', $blog->date);
        }

        return $xml;
    }

    /**
     * Fetch blog table.
     *
     * @return array|object
     */
    public function getBlogTable()
    {
        if (!$this->blogTable) {
            $sm = $this->getServiceLocator();
            $this->blogTable = $sm->get('Blog\Model\BlogTable');
        }

        return $this->blogTable;
    }

}