<?php
/**
 * @category    Bubble
 * @package     Bubble_QueryGrid
 * @version     1.0.0
 * @copyright   Copyright (c) 2015 BubbleShop (https://www.bubbleshop.net)
 */
class Bubble_QueryGrid_Block_Adminhtml_Query_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('queryResultsGrid');
        $this->setFilterVisibility(false);
        $this->setPagerVisibility(false);
    }

    protected function _prepareCollection()
    {
        if (isset($this->_collection)) {
            return $this->_collection;
        }

        $collection = new Varien_Data_Collection();
        foreach ($this->_getSqlQueryResults() as $result) {
            $collection->addItem(new Varien_Object($result));
        }

        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $results = $this->_getSqlQueryResults();
        if (!empty($results)) {
            $cols = array_keys($results[0]);
            foreach ($cols as $col) {
                $header = uc_words($col, ' ');
                $this->addColumn($col, array(
                    'header'    => Mage::helper('bubble_qgrid')->__($header),
                    'index'     => $col,
                    'type'      => 'text',
                    'sortable'  => false,
                ));
            }
        }

        return parent::_prepareColumns();
    }

    public function getQuery()
    {
        return Mage::registry('query_grid');
    }

    protected function _getSqlQueryResults()
    {
        $results = array();
        $query = $this->getQuery();
        if ($query) {
            try {
                $results = $query->getResults();
            } catch (Exception $e) {
                Mage::logException($e);
                $this->setEmptyText($e->getMessage());
                $this->setEmptyTextClass('error');
            }
        }

        return $results;
    }
}