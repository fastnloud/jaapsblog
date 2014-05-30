<?php

namespace Blog\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;

class ReplyTable extends AbstractTableGateway
{

    /**
     * @var string
     */
    protected $table = 'blog_reply';

    /**
     * Init.
     *
     * @param Adapter $adapter
     */
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;

        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Reply());

        $this->initialize();
    }

    /**
     * Fetch replies (can be filtered by Blog id)
     *
     * @param null $idBlog
     * @return null|\Zend\Db\ResultSet\ResultSetInterface
     */
    public function fetchAll($idBlog = null)
    {
        $select = $this->getSql()->select();
        $select->order('timestamp asc');

        if (null !== $idBlog) {
            $select->where(array('id_blog = ?' => (int) $idBlog));
        }

        return $this->selectWith($select);
    }

    /**
     * Fetch a single reply by id.
     *
     * @param $id
     * @return mixed
     */
    public function fetch($id)
    {
        $select = $this->getSql()->select();
        $select->where(array(
            'id' => (int) $id,
        ));

        return $this->selectWith($select)->current();
    }

    /**
     * Remove reply by id.
     *
     * @param $id
     * @return int
     */
    public function remove($id)
    {
        return $this->delete(array(
            'id' => (int) $id
        ));
    }

    /**
     * Save reply (either insert or update).
     *
     * @param Reply $reply
     * @return bool|int
     */
    public function save(Reply $reply)
    {
        $data = array(
            'id_blog'  => $reply->getIdBlog(),
            'name'     => $reply->getName(),
            'comment'  => $reply->getComment()
        );

        // whenever logged on
        if (0 == $reply->getId() && true === AUTHENTICATED) {
            $data['is_admin'] = true;
        }

        if (0 == $reply->getId() || true !== AUTHENTICATED) {
            return $this->insert($data);
        } elseif ($this->fetch($reply->getId())) {
            return $this->update(
                $data,
                array(
                    'id' => $reply->getId(),
                )
            );
        }

        return false;
    }

}