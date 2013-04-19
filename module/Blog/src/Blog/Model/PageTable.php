<?php

namespace Blog\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;

class PageTable extends AbstractTableGateway
{
    protected $table = 'page';
    
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Page());
    
        $this->initialize();
    }

    public function getPages()
    {
        $select = $this->getSql()->select();
        $select->order('title asc');

        if (true !== AUTHENTICATED) {
            $select->where("status = 'online' or status = 'online-not-in-menu");
        }

        return $this->selectWith($select);
    }

    public function getPage($id)
    {
        $id = (int) $id;

        $select = $this->getSql()->select();
        $select->where(array(
            'id' => $id,
        ));

        if (true !== AUTHENTICATED) {
            $select->where("status = 'online' or status = 'online-not-in-menu");
        }

        $row = $this->selectWith($select)->current();

        if (!$row) {
            return false;
        }

        return $row;
    }

    public function getPageByUrlString($urlString)
    {
        $select = $this->getSql()->select();
        $select->where(array(
            'url_string' => $urlString,
        ));

        if (true !== AUTHENTICATED) {
            $select->where("status = 'online' or status = 'online-not-in-menu");
        }

        $row = $this->selectWith($select)->current();

        if (!$row) {
            return false;
        }

        return $row;
    }

    public function deletePage($id)
    {
        $id = (int) $id;
        $this->delete(array(
            'id' => $id
        ));
    }
    
    public function save(Page $page)
    {
        $data = array(
            'title'             => $page->title,
            'label'             => $page->label,
            'url_string'        => $page->url_string,
            'route'             => $page->route,
            'content'           => $page->content,
            'status'            => $page->status,
            'priority'          => $page->priority,
            'meta_title'        => $page->meta_title,
            'meta_description'  => $page->meta_description,
            'meta_keywords'     => $page->meta_keywords
        );

        $id = (int) $page->id;

        if (0 == $id) {
            $this->insert($data);
        } elseif ($this->getPage($id)) {
            $this->update(
                $data,
                array(
                    'id' => $id,
                )
            );
        }
    }
}