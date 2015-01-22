<?php
/**
 * @category    Bubble
 * @package     Bubble_QueryGrid
 * @version     1.0.0
 * @copyright   Copyright (c) 2015 BubbleShop (https://www.bubbleshop.net)
 */
class Bubble_QueryGrid_Block_Adminhtml_Query_List extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_blockGroup = 'bubble_qgrid';
        $this->_controller = 'adminhtml_query_list';
        $this->_headerText = Mage::helper('bubble_qgrid')->__('Queries');
    }

    public function getHeaderCssClass()
    {
        return '';
    }
}