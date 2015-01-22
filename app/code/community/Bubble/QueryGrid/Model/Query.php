<?php
/**
 * @category    Bubble
 * @package     Bubble_QueryGrid
 * @version     1.0.0
 * @copyright   Copyright (c) 2015 BubbleShop (https://www.bubbleshop.net)
 */
class Bubble_QueryGrid_Model_Query extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('bubble_qgrid/query');
    }

    public function getResults()
    {
        return $this->getResource()->getResults($this);
    }
}