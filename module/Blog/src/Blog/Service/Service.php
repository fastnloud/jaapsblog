<?php

namespace Blog\Service;

abstract class Service
{

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
                $data[] = $row;
            }

            return array('data' => $data);
        } elseif (is_bool($result)) {
            return array('success' => $result);
        }
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