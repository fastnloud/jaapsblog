<?php

namespace Blog\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Blog\Model\ReplyTable;

class Replies extends AbstractHelper
{

    /**
     * @var ReplyTable
     */
    protected $replyTable;

    /**
     * Fetch replies of blog post if any.
     *
     * @param int $idBlog
     * @param string $title
     * @return string (HTML string)
     */
    public function __invoke($idBlog, $title)
    {
        $replies = $this->getReplyTable()->fetchAll($idBlog);

        $count = count($replies);
        if ($count > 0) {
            $articles[] = "<h5 class=\"replied\">" . $count . " response"
                        . (($count > 1) ? 's' : '') . " "
                        . "on the article "
                        . "<i>" . $this->getView()->escapeHtml($title) . "</i>"
                        . "</h5>";

            foreach ($replies as $key => $value) {
                $name     = $this->getView()->escapeHtml($value->getName());
                $comment  = nl2br($this->getView()->escapeHtml($value->getComment()));
                $datetime = $this->getView()->date($value->getTimestamp(), 'Y-m-d');
                $date     = $this->getView()->date($value->getTimestamp(), 'd M h:i a');

                // odd even classes
                $class = (0 == $key%2 ? 'odd' : 'even');
                if ($value->getIsAdmin()) {
                    $class .= ' admin';
                    $name  .= ' <i>(admin)</i>';
                }

                // add to list
                $articles[] = "<article class=\"replies $class\">" . PHP_EOL
                            . "    <h2>{$name} <time datetime=\"{$datetime}\">{$date}</time></h2>" . PHP_EOL
                            . "    <p>{$comment}</p>" . PHP_EOL
                            . "</article>" . PHP_EOL;
            }

            return implode(PHP_EOL, $articles);
        }

        return "<p class=\"replies no-replies\"><i>No replies yet.</i></p>";
    }

    /**
     * @param \Blog\Model\ReplyTable $replyTable
     */
    public function setReplyTable(ReplyTable $replyTable)
    {
        $this->replyTable = $replyTable;
    }

    /**
     * @return \Blog\Model\ReplyTable
     */
    protected function getReplyTable()
    {
        return $this->replyTable;
    }

}