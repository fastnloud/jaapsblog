<?php

namespace Blog\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Predicate;

class PageTable extends AbstractTableGateway
{

    /**
     * @var string
     */
    protected $table = 'page';

    /**
     * Init.
     *
     * @param Adapter $adapter
     */
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Page());
    
        $this->initialize();
    }

    /**
     * Fetch all pages.
     * - No status filter when authenticated
     *
     * @return null|\Zend\Db\ResultSet\ResultSetInterface
     */
    public function getPages()
    {
        $select = $this->getSql()->select();
        $select->order('priority asc');

        if (true !== AUTHENTICATED) {
            $select->where(array(
                new Predicate\PredicateSet(
                    array(
                        new Predicate\Operator('status', '<>', 'offline')
                    ),
                    Predicate\PredicateSet::COMBINED_BY_OR
                )
            ));
        }

        return $this->selectWith($select);
    }

    /**
     * Fetch page by id.
     * - No status filter when authenticated
     *
     * @param $id
     * @return mixed
     */
    public function getPage($id)
    {
        $id = (int) $id;

        $select = $this->getSql()->select();
        $select->where(array(
            'id' => $id,
        ));

        if (true !== AUTHENTICATED) {
            $select->where(array(
                new Predicate\PredicateSet(
                    array(
                        new Predicate\Operator('status', '<>', 'offline')
                    ),
                    Predicate\PredicateSet::COMBINED_BY_OR
                )
            ));
        }

        return $this->selectWith($select)->current();
    }

    /**
     * Fetch page by URL String.
     * - No status filter when authenticated
     *
     * @param $urlString
     * @return mixed
     */
    public function getPageByUrlString($urlString)
    {
        $select = $this->getSql()->select();
        $select->where(array(
            'url_string' => $urlString,
        ));

        if (true !== AUTHENTICATED) {
            $select->where(array(
                new Predicate\PredicateSet(
                    array(
                        new Predicate\Operator('status', '<>', 'offline')
                    ),
                    Predicate\PredicateSet::COMBINED_BY_OR
                )
            ));
        }

        return $this->selectWith($select)->current();
    }

    /**
     * Delete page by id.
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
     * Save page (either insert or update).
     *
     * @param Page $page
     * @return int
     */
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
            $result = $this->insert($data);
        } elseif ($this->getPage($id)) {
            $result = $this->update(
                $data,
                array(
                    'id' => $id,
                )
            );
        }

        return $result;
    }

}