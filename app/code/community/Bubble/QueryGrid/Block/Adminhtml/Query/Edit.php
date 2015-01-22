<?php
/**
 * @category    Bubble
 * @package     Bubble_QueryGrid
 * @version     1.0.0
 * @copyright   Copyright (c) 2015 BubbleShop (https://www.bubbleshop.net)
 */
class Bubble_QueryGrid_Block_Adminhtml_Query_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_addButton('savecontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save and Continue Edit'),
            'onclick' => "$('edit_form').action += 'continue/true/'; editForm.submit();",
            'class'     => 'save'
        ), 5);

        $this->_objectId = 'id';
        $this->_blockGroup = 'bubble_qgrid';
        $this->_controller = 'adminhtml_query';
    }

    public function getQuery()
    {
        return Mage::registry('query_grid');
    }

    public function getHeaderText()
    {
        $query = $this->getQuery();
        if ($query && $query->getId() ) {
            return Mage::helper('bubble_qgrid')->__("Edit Query '%s'", $this->escapeHtml($query->getName()));
        } else {
            return Mage::helper('bubble_qgrid')->__('New Query');
        }
    }

    public function getHeaderCssClass()
    {
        return '';
    }

    public function getFormActionUrl()
    {
        return $this->getUrl('*/*/save');
    }

    public function getDeleteUrl()
    {
        return $this->getUrl('*/*/delete', array($this->_objectId => $this->getRequest()->getParam($this->_objectId)));
    }
}