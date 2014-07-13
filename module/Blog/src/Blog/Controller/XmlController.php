<?php

namespace Blog\Controller;

use Blog\Service\Blog as BlogService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\FeedModel;
use Zend\View\Model\ViewModel;

class XmlController extends AbstractActionController
{

    /**
     * @var BlogService
     */
    protected $blogService;

    /**
     * Render sitemap from navigation.
     *
     * @return ViewModel
     */
    public function sitemapAction()
    {
        $this->getResponse()->getHeaders()->addHeaderLine('Content-Type', 'text/xml');

        $viewModel = new ViewModel();
        $viewModel->setTerminal(true);

        return $viewModel;
    }

    /**
     * Create RSS feed of blog items.
     *
     * @return FeedModel
     */
    public function rssAction()
    {
        $baseUrl = $this->getRequest()->getUri()->getScheme()
                 . '://' . $this->getRequest()->getUri()->getHost();

        $feed = new \Zend\Feed\Writer\Feed;
        $feed->setTitle(\Blog\Service\Page::websiteGlobals('title'));
        $feed->setDescription(\Blog\Service\Page::websiteGlobals('description'));
        $feed->setLink($baseUrl);
        $feed->setFeedLink($baseUrl, 'atom');
        $feed->addAuthor(array(
            'name'  => \Blog\Service\Page::websiteGlobals('author'),
            'email' => \Blog\Service\Page::websiteGlobals('email'),
            'uri'   => $baseUrl,
        ));

        $items = $this->getBlogService()->getItems();

        if ($items->count() > 0) {
            foreach($items as $key => $item) {
                $dateTime = new \DateTime($item->getDate());

                if (0 === $key) { // last modified
                    $feed->setDateModified($dateTime);
                }

                $entry = $feed->createEntry();
                $entry->setTitle($item->getTitle());
                $entry->setLink($baseUrl . $this->getBlogService()->getUriPath($item));
                $entry->setDateModified($dateTime);
                $entry->setDateCreated($dateTime);
                $entry->setDescription($item->getLead());
                $entry->setContent($item->getContent());
                $feed->addEntry($entry);
            }
        }

        $feedModel = new FeedModel();
        $feedModel->setFeed($feed);

        return $feedModel;
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