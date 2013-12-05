<?php

namespace Blog\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Blog\Model\ReplyTable;

class LatestReplies extends AbstractHelper
{

    /**
     * @var ReplyTable
     */
    protected $replyTable;

    /**
     * Show the latest blog replies.
     *
     * @param int $show
     * @return string (HTML string)
     */
    public function __invoke($show = 10)
    {
        $replies = $this->getReplyTable()->getLatestReplies($show);

        if ($replies->count() > 0) {
            foreach ($replies as $reply) {
                $blogPost = $this->view->navigation('navigation')->findBy('id_blog_post',$reply->id_blog);
                if ($blogPost) {
                    $name = $this->view->escapeHtml($reply->name);
                    if (mb_strlen($name) > 40) {
                        $name = mb_substr($name, 0, 40) . '...';
                    }

                    $comment = $this->view->escapeHtml($reply->comment);
                    if (mb_strlen($comment) > 80) {
                        $comment = mb_substr($comment, 0, 80) . '...';
                    }

                    $href = $blogPost->getHref();

                    $list[] = '<li><strong>' . $name . '</strong><a href="' . $href . '">' . $comment . '</a></li>';
                }
            }

            return '<aside>' . PHP_EOL
                 . '    <ul>'  . PHP_EOL
                 . '        ' . implode(PHP_EOL . '        ', $list) . PHP_EOL
                 . '    </ul>'  . PHP_EOL
                 . '</aside>';
        } else {
            return '';
        }
    }

    /**
     * Set table object.
     * @param \Blog\Model\ReplyTable $replyTable
     */
    public function setReplyTable(ReplyTable $replyTable)
    {
        $this->replyTable = $replyTable;
    }

    /**
     * Get table object.
     * @return \Blog\Model\ReplyTable
     */
    public function getReplyTable()
    {
        return $this->replyTable;
    }

}