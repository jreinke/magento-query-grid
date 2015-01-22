<?php
/**
 * @category    Bubble
 * @package     Bubble_QueryGrid
 * @version     1.0.0
 * @copyright   Copyright (c) 2015 BubbleShop (https://www.bubbleshop.net)
 */
class Bubble_QueryGrid_Model_Resource_Query extends Mage_Core_Model_Resource_Db_Abstract
{
    protected $_results;

    protected function _construct()
    {
        $this->_init('bubble_qgrid/query', 'query_id');
    }

    public function getResults(Bubble_QueryGrid_Model_Query $query)
    {
        if (null === $this->_results) {
            $this->_results = array();
            $sql = trim($query->getSqlQuery());
            if ($sql) {
                if (stripos($sql, 'select') !== 0) {
                    Mage::throwException('SQL query must start with SELECT');
                }
                $adapter = $this->_getReadAdapter();
                $this->_results = $adapter->fetchAll($sql);
            }
        }

        return $this->_results;
    }
}