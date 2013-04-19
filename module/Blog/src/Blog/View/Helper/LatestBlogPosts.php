<?php

namespace Blog\View\Helper;

use Zend\View\Helper\AbstractHelper;

use Blog\Model\Blog;

class LatestBlogPosts extends AbstractHelper
{

    /**
     * Show the latest blog posts.
     *
     * @param int $show
     * @return string (HTML string)
     */
    public function __invoke($show = 5)
    {
        $blogPosts = $this->view->navigation('navigation')->findAllBy('route', 'blog_post');

        if ($blogPosts) {
            foreach ($blogPosts as $key => $post) {
                if ($key == $show) {
                    break;
                }

                $title    = $this->view->escapeHtml($post->label);
                $datetime = $this->view->escapeHtml($post->date);
                $date     = $this->view->date($post->date, 'd M');
                $href     = $post->getHref();
                // Add to list.
                $list[] = "<li><a href=\"{$href}\" title=\"Read article: {$title}\">"
                        . "<time datetime=\"{$datetime}\">{$date} - </time>{$title}"
                        . "</a></li>";
            }

            // Return items.
            return '<ul>' . implode(PHP_EOL, $list) . '</ul>';
        }

        return '<p>No items found.</p>';
    }
}