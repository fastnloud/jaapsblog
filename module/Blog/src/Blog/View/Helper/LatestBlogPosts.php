<?php

namespace Blog\View\Helper;

use Zend\View\Helper\AbstractHelper;

use Blog\Model\Blog;

class LatestBlogPosts extends AbstractHelper
{
    protected $blogTable;

    /**
     * Fetch blog table.
     *
     * @param \Zend\ServiceManager\ServiceManager $sm
     */
    public function __construct(\Zend\ServiceManager\ServiceManager $sm)
    {
        $this->blogTable = $sm->getServiceLocator()->get('Blog\Model\BlogTable');
    }

    /**
     * Show the latest blog posts.
     *
     * @param int $show
     * @return string (HTML string)
     */
    public function __invoke($show = 5)
    {
        $index = $this->blogTable->getIndex(null, null, $show);

        if ($index) {
            foreach ($index as $key => $value) {
                $title    = $this->view->escapeHtml($value->title);
                $datetime = $this->view->escapeHtml($value->date);
                $date     = $this->view->date($value->date, 'd M');

                // Generate URL with helper.
                $url = $this->view->url('blog', array(
                    'action' => 'view',
                    'id'     => $value->id,
                    'title'  => $this->view->urlString($value->title)
                ));

                // Add to list.
                $list[] = "<li><a href=\"{$url}\" title=\"Read article: {$title}\">"
                        . "<time datetime=\"{$datetime}\">{$date} - </time>{$title}"
                        . "</a></li>";
            }

            // Return items.
            return '<ul>' . implode(PHP_EOL, $list) . '</ul>';
        }

        return '<p>No items found.</p>';
    }
}