<?php

namespace Blog\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Predicate;

class BlogTable extends AbstractTableGateway
{
    protected $table = 'blog';
    
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Blog());
    
        $this->initialize();
    }
    
    public function getIndex($q = null, $c = null, $l = null)
    {
        $select = $this->getSql()->select();
        $select->order('date desc');
        
        // Filter if a search query string has been given.
        if ($q) {
            $q = "%$q%"; // Search param.
            $select->where(array(
                new Predicate\PredicateSet(
                    array(
                        new Predicate\Like('title', $q),
                        new Predicate\Like('subtitle', $q),
                        new Predicate\Like('lead', $q),
                        new Predicate\Like('content', $q),
                    ),
                    Predicate\PredicateSet::COMBINED_BY_OR
                )
            ));
        }

        // Filter on category.
        if ($c) {
            $select->where(array('category = ?' => $c));
        }

        // Set limit.
        if ($l) {
            $select->limit($l);
        }

        // Show all if authenticated.
        if (true !== AUTHENTICATED) {
            $select = $select->where(array('status = ?' => 'online'))
                    ->where('date <= CURDATE()');
        }

        return $this->selectWith($select);
    }
    
    public function getBlogItem($id)
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

        $row = $this->selectWith($select)->current();

        if (!$row) {
            return false;
        }

        return $row;
    }
    
    public function deleteBlogItem($id)
    {
        $id = (int) $id;
        $this->delete(array(
            'id' => $id
        ));
    }
    
    public function save(Blog $blog)
    {
        $data = array(
            'title'             => $blog->title,
            'subtitle'          => $blog->subtitle,
            'lead'              => $blog->lead,
            'content'           => $blog->content,
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
            $this->insert($data);
        } elseif ($this->getBlogItem($id)) {
            $this->update(
                $data,
                array(
                    'id' => $id,
                )
            );
        }
    }
}