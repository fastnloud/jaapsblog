<?php

namespace Blog\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;

class ReplyTable extends AbstractTableGateway
{
    protected $table = 'blog_reply';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;

        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Reply());

        $this->initialize();
    }

    public function getReplies($idBlog = null)
    {
        $select = $this->getSql()->select();
        $select->order('timestamp asc');

        if (null !== $idBlog) {
            $select->where(array('id_blog = ?' => (int)$idBlog));
        }

        return $this->selectWith($select);
    }

    public function getReply($id)
    {
        $id = (int) $id;

        $select = $this->getSql()->select();
        $select->where(array(
            'id' => $id,
        ));

        $row = $this->selectWith($select)->current();

        if (!$row) {
            return false;
        }

        return $row;
    }

    public function getLatestReplies($limit = 10)
    {
        $select = $this->getSql()->select();
        $select->join('blog', 'blog.id=' . $this->getTable(). '.id_blog', array(

        ), $select::JOIN_INNER);
        $select->order('timestamp ' . $select::ORDER_DESCENDING);
        $select->limit($limit);

        return $this->selectWith($select);
    }

    public function deleteReply($id)
    {
        $this->delete(array(
            'id' => (int)$id
        ));
    }

    public function save(Reply $reply)
    {
        $data = array(
            'id_blog'  => $reply->id_blog,
            'name'     => $reply->name,
            'comment'  => $reply->comment
        );

        $id = (int) $reply->id;

        // only set admin to true on insert
        // when logged on
        if (0 == $id && true === AUTHENTICATED) {
            $data['is_admin'] = true;
        }

        if (0 == $id || true !== AUTHENTICATED) {
            $this->insert($data);
        } elseif ($this->getReply($id)) {
            $this->update(
                $data,
                array(
                    'id' => $id,
                )
            );
        }
    }
}