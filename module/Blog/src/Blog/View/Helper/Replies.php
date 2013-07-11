<?php

namespace Blog\View\Helper;

use Zend\View\Helper\AbstractHelper;

use Blog\Model\Reply;

class Replies extends AbstractHelper
{
    protected $replyTable;

    /**
     * Fetch reply table.
     *
     * @param \Zend\ServiceManager\ServiceManager $sm
     */
    public function __construct(\Zend\ServiceManager\ServiceManager $sm)
    {
        $this->replyTable = $sm->getServiceLocator()->get('Blog\Model\ReplyTable');
    }

    /**
     * Fetch replies of blog post if any.
     *
     * @param int $idBlog
     * @param string $title
     * @return string (HTML string)
     */
    public function __invoke($idBlog, $title)
    {
        $replies = $this->replyTable->getReplies($idBlog);

        $count = count($replies);
        if ($count > 0) {
            $articles[] = "<h5 class=\"replied\">" . $count . " response"
                        . (($count > 1) ? 's' : '') . " "
                        . "on the article "
                        . "<i>" . $this->view->escapeHtml($title) . "</i>"
                        . "</h5>";

            foreach ($replies as $key => $value) {
                $name     = $this->view->escapeHtml($value->name);
                $comment  = nl2br($this->view->escapeHtml($value->comment));
                $datetime = $this->view->date($value->timestamp, 'Y-m-d');
                $date     = $this->view->date($value->timestamp, 'd M h:i a');

                // odd even classes
                $class = (0 == $key%2 ? 'odd' : 'even');
                if (true == $value->is_admin) {
                    $class .= ' admin';
                    $name  .= ' <i>(admin)</i>';
                }

                // Add to list.
                $articles[] = "<article class=\"replies $class\">" . PHP_EOL
                            . "    <span>{$name} <time datetime=\"{$datetime}\">{$date}</time></span>" . PHP_EOL
                            . "    <p>{$comment}</p>" . PHP_EOL
                            . "</article>" . PHP_EOL;
            }

            return implode(PHP_EOL, $articles);
        }

        return "<article class=\"replies\">No replies yet.</article>";
    }
}