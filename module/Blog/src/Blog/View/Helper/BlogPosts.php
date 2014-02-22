<?php

namespace Blog\View\Helper;

use Zend\View\Helper\AbstractHelper;

class BlogPosts extends AbstractHelper
{

    /**
     * Show the latest blog posts.
     *
     * @param int $show
     * @return string (HTML string)
     */
    public function __invoke($show = 5)
    {
        $blogPosts = $this->getView()->navigation('navigation')->findAllBy('route', 'blog_post');

        if ($blogPosts) {
            foreach ($blogPosts as $key => $post) {
                if ($key == $show) {
                    break;
                }

                $title    = $this->getView()->escapeHtml($post->label);
                $datetime = $this->getView()->escapeHtml($post->date);
                $date     = $this->getView()->date($post->date, 'd M');
                $href     = $post->getHref();

                // add to list
                $list[] = "<li><a href=\"{$href}\" title=\"Read article: {$title}\">"
                        . "<time datetime=\"{$datetime}\">{$date} - </time>{$title}"
                        . "</a></li>";
            }

            // Return items.
            return '<ul>' . implode(PHP_EOL, $list) . '</ul>';
        }

        return false;
    }

}