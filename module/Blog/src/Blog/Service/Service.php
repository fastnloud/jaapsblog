<?php

namespace Blog\Service;

use Zend\Http\Request;

abstract class Service
{

    /**
     * @var array
     */
    protected $config;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var null|string
     */
    protected $returnType = null;

    /**
     * Return result set as the 'expected' data array
     * used for Json models.
     *
     * @param $result
     * @return array
     */
    protected function returnAsJsonArray($result)
    {
        $data = array();

        if ($result instanceof \Zend\Db\ResultSet\ResultSet) {
            foreach ($result as $row) {
                $data[] = $row->getArrayCopy();
            }

            return array('data' => $data);
        } elseif (is_bool($result)) {
            return array('success' => $result);
        }
    }

    protected function encodeAndValidateJsonData($model = null)
    {
        $params = $this->getRequest()->getPost();

        if ($this->getRequest()->isPost()) {
            if(isset($params['data'])) {
                $data = json_decode($params['data'], true);

                // validate if model has been given
                if ($model && isset($data['id'])) {
                    $model->exchangeArray($data);

                    $form = new \Zend\Form\Form();
                    $form->bind($model);

                    if ($form->isValid()) {
                        return $model;
                    }
                }
                // check if id is set
                elseif (isset($data['id'])) {
                    return $data;
                }
            }
        }

        return false;
    }

    /**
     * @param array $config
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
    }

    /**
     * @return array
     */
    protected function getConfig()
    {
        return $this->config;
    }

    /**
     * @param \Zend\Http\Request $request
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return \Zend\Http\Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param string $returnType
     */
    public function setReturnType($returnType)
    {
        $this->returnType = ('JsonArray' == $returnType ? 'JsonArray' : null);
        return $this;
    }

    /**
     * @return string
     */
    public function getReturnType()
    {
        return $this->returnType;
    }

}