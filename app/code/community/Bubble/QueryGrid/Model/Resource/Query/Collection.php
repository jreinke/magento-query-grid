<?php
/**
 * @category    Bubble
 * @package     Bubble_QueryGrid
 * @version     1.0.0
 * @copyright   Copyright (c) 2015 BubbleShop (https://www.bubbleshop.net)
 */
class Bubble_QueryGrid_Model_Resource_Query_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    public function _construct()
    {
        $this->_init('bubble_qgrid/query');
    }

    public function fetchPairs($col1 = 'query_id', $col2 = 'name')
    {
        $this->getSelect()
            ->reset(Zend_Db_Select::COLUMNS)
            ->columns(array($col1, $col2));

        return $this->getResource()->getReadConnection()->fetchPairs($this->getSelect());
    }
}