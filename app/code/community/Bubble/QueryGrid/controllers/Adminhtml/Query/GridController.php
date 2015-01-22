<?php
/**
 * @category    Bubble
 * @package     Bubble_QueryGrid
 * @version     1.0.0
 * @copyright   Copyright (c) 2015 BubbleShop (https://www.bubbleshop.net)
 */
class Bubble_QueryGrid_Adminhtml_Query_GridController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->_title($this->__('Query Grid'))
            ->_title(Mage::helper('bubble_qgrid')->__('Queries'));
        $this->loadLayout();
        $this->_setActiveMenu('system/bubble_qgrid');
        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('bubble_qgrid/query')->load($id);
        if ($id && !$model->getId()) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bubble_qgrid')->__('This query no longer exists.')
            );

            return $this->_redirect('*/*/');
        }

        Mage::register('query_grid', $model);

        try {
            $model->getResults(); // Throws exception if sql query is invalid
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }

        $this->_title($this->__('Edit Query'));
        $this->loadLayout();
        $this->_setActiveMenu('system/bubble_qgrid');
        $this->renderLayout();
    }

    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            $id = $this->getRequest()->getParam('query_id');
            $model = Mage::getModel('bubble_qgrid/query')->load($id);
            if ($id && !$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bubble_fpc')->__('This query no longer exists.')
                );

                return $this->_redirect('*/*/');
            }

            try {
                $model->setData($data);
                $model->getResults(); // Throws exception if sql query is invalid
                $model->save();

                Mage::getSingleton('adminhtml/session')
                    ->addSuccess(Mage::helper('bubble_qgrid')->__('The query has been saved.'));

                if ($continue = $this->getRequest()->getParam('continue')) {
                    return $this->_redirect('*/*/edit', array('id' => $model->getId()));
                } else {
                    return $this->_redirect('*/*/');
                }
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());

                return $this->_redirect('*/*/edit', array('id' => $id));
            }
        } else {
            return $this->_redirect('*/*/');
        }
    }

    public function deleteAction()
    {
        if ($id = $this->getRequest()->getParam('id')) {
            try {
                $model = Mage::getModel('bubble_qgrid/query');
                $model->load($id);
                $model->delete();
                Mage::getSingleton('adminhtml/session')
                    ->addSuccess(Mage::helper('bubble_qgrid')->__('The query has been deleted.'));

                return $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());

                return $this->_redirect('*/*/');
            }
        }

        Mage::getSingleton('adminhtml/session')
            ->addError(Mage::helper('bubble_qgrid')->__('Unable to find a query to delete.'));

        return $this->_redirect('*/*/');
    }
}