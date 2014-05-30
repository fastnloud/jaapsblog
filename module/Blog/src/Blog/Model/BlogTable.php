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
        $select = $this->getSql()->select();
        $select->where(array(
            'id' => (int) $id,
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
            'title'             => $blog->getTitle(),
            'subtitle'          => $blog->getSubtitle(),
            'lead'              => $blog->getLead(),
            'content'           => $blog->getContent(),
            'author'            => $blog->getAuthor(),
            'category'          => $blog->getCategory(),
            'date'              => $blog->getDate(),
            'status'            => $blog->getStatus(),
            'meta_title'        => $blog->getMetaTitle(),
            'meta_description'  => $blog->getMetaDescription(),
            'meta_keywords'     => $blog->getMetaKeywords()
        );

        if (0 == $blog->getId()) {
            return $this->insert($data);
        } elseif ($this->fetch($blog->getId())) {
            return $this->update(
                $data,
                array(
                    'id' => $blog->getId(),
                )
            );
        }

        return false;
    }

}