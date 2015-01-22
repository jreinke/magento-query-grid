<?php
/**
 * @category    Bubble
 * @package     Bubble_QueryGrid
 * @version     1.0.0
 * @copyright   Copyright (c) 2015 BubbleShop (https://www.bubbleshop.net)
 */
class Bubble_QueryGrid_Block_Adminhtml_Query_List_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('qgridGrid');
        $this->setDefaultSort('name');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setVarNameFilter('qgrid_filter');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('bubble_qgrid/query')
            ->getCollection();
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('query_id', array(
            'header'         => Mage::helper('bubble_qgrid')->__('Id'),
            'index'          => 'query_id',
            'type'           => 'number',
        ));

        $this->addColumn('name', array(
            'header'         => Mage::helper('bubble_qgrid')->__('Name'),
            'index'          => 'name',
            'type'           => 'text',
        ));

        $this->addColumn('name', array(
            'header'         => Mage::helper('bubble_qgrid')->__('Name'),
            'index'          => 'name',
            'type'           => 'text',
        ));

        $this->addColumn('enable_chart', array(
            'header'         => Mage::helper('bubble_qgrid')->__('Enable Chart'),
            'index'          => 'enable_chart',
            'width'          => '80px',
            'align'          => 'center',
            'type'           => 'options',
            'options'        => array(
                '1' => Mage::helper('adminhtml')->__('Yes'),
                '0' => Mage::helper('adminhtml')->__('No'),
            ),
        ));

        $this->addColumn('action',
            array(
                'header'    => Mage::helper('adminhtml')->__('Action'),
                'width'     => '50px',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption' => Mage::helper('bubble_qgrid')->__('Delete'),
                        'url'     => array(
                            'base'   => '*/*/delete',
                        ),
                        'field'   => 'id',
                        'confirm' => Mage::helper('bubble_qgrid')->__('Are you sure?')
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
            )
        );

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array(
            'id' => $row->getId()
        ));
    }
}