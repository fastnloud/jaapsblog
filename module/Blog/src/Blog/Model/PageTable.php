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
    public function fetchAll()
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
    public function fetch($id)
    {
        $select = $this->getSql()->select();
        $select->where(array(
            'id' => (int) $id,
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
    public function fetchByUrlString($urlString)
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
     * @return bool|int
     */
    public function save(Page $page)
    {
        $data = array(
            'title'             => $page->getTitle(),
            'label'             => $page->getLabel(),
            'url_string'        => $page->getUrlString(),
            'route'             => $page->getRoute(),
            'content'           => $page->getContent(),
            'status'            => $page->getStatus(),
            'priority'          => $page->getPriority(),
            'meta_title'        => $page->getMetaTitle(),
            'meta_description'  => $page->getMetaDescription(),
            'meta_keywords'     => $page->getMetaKeywords()
        );

        if (0 == $page->getId()) {
            return $this->insert($data);
        } elseif ($this->fetch($page->getId())) {
            return $this->update(
                $data,
                array(
                    'id' => $page->getId(),
                )
            );
        }

        return false;
    }

}