<?php

namespace Blog\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Predicate;
use Zend\Db\Sql\Expression;

class BlogTable extends AbstractTableGateway
{

    /**
     * @var string
     */
    protected $table = 'blog';

    /**
     * Init.
     *
     * @param Adapter $adapter
     */
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Blog());
    
        $this->initialize();
    }

    /**
     * Fetch multiple Blog items.
     * - No status filter when authenticated
     *
     * @param null $query
     * @return null|\Zend\Db\ResultSet\ResultSetInterface
     */
    public function fetchAll($query = null)
    {
        $select = $this->getSql()->select();
        $select->order('date desc');
        
        // filter if a search query string has been given
        if ($query) {
            $select->where(array(
                new Predicate\PredicateSet(
                    array(
                        new Predicate\Like('title', "%$query%"),
                        new Predicate\Like('subtitle', "%$query%"),
                        new Predicate\Like('lead', "%$query%"),
                        new Predicate\Like('content', "%$query%"),
                    ),
                    Predicate\PredicateSet::COMBINED_BY_OR
                )
            ));
        }

        // show all when authenticated
        if (true !== AUTHENTICATED) {
            $select = $select->where(array('status = ?' => 'online'))
                    ->where('date <= CURDATE()');
        }

        // fetch comments
        $select->join('blog_reply', 'blog_reply.id_blog=blog.id', array(
            'comments' => new Expression('count(blog_reply.id)'),
        ), $select::JOIN_LEFT);

        $select->group('id');

        return $this->selectWith($select);
    }

    /**
     * Fetch a single Blog item.
     * - No status filter when authenticated
     *
     * @param $id
     * @return mixed
     */
    public function fetch($id)
    {
        $id = (int) $id;

        $select = $this->getSql()->select();
        $select->where(array(
            'id' => $id,
        ));
        
        if (true !== AUTHENTICATED) {
            $select = $select->where(array('status = ?' => 'online'))
                    ->where('date <= CURDATE()');
        }

        return $this->selectWith($select)->current();
    }

    /**
     * Delete blog item by id.
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
     * Save a blog item (either insert or update).
     *
     * @param Blog $blog
     * @return bool|int
     */
    public function save(Blog $blog)
    {
        $data = array(
            'title'             => $blog->title,
            'subtitle'          => $blog->subtitle,
            'lead'              => $blog->lead,
            'content'           => $blog->content,
            'author'            => $blog->author,
            'category'          => $blog->category,
            'rating'            => $blog->rating,
            'date'              => $blog->date,
            'status'            => $blog->status,
            'amazon_item_id'    => $blog->amazon_item_id,
            'meta_title'        => $blog->meta_title,
            'meta_description'  => $blog->meta_description,
            'meta_keywords'     => $blog->meta_keywords
        );
    
        $id = (int) $blog->id;
    
        if (0 == $id) {
            return $this->insert($data);
        } elseif ($this->fetch($id)) {
            return $this->update(
                $data,
                array(
                    'id' => $id,
                )
            );
        }

        return false;
    }

}