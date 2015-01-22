<?php
/**
 * @category    Bubble
 * @package     Bubble_QueryGrid
 * @version     1.0.0
 * @copyright   Copyright (c) 2015 BubbleShop (https://www.bubbleshop.net)
 */
class Bubble_QueryGrid_Block_Adminhtml_Query_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('query_grid_form');
    }

    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
            'id'        => 'edit_form',
            'action'    => $this->getData('action'),
            'method'    => 'post'
        ));

        $query = Mage::registry('query_grid');
        $collection = Mage::getModel('bubble_qgrid/query')->getCollection();
        if ($query && $query->getId()) {
            $collection->addFieldToFilter('query_id', array('neq' => $query->getId()));
        }

        $queries = $collection->fetchPairs();
        if (!empty($queries)) {
            $fieldset = $form->addFieldset('fieldset_switch', array(
                'legend'    => false
            ));
            asort($queries);
            $values = array();
            foreach ($queries as $id => $name) {
                $url = $this->getUrl('*/*/edit', array('id' => $id));
                $values[] = array(
                    'value' => $url,
                    'label' => $name,
                );
            }
            $empty = array('value' => '', 'label' => Mage::helper('adminhtml')->__('-- Please select --'));
            array_unshift($values, $empty);
            $fieldset->addField('queries', 'select',
                array(
                    'name'      => 'queries',
                    'label'     => Mage::helper('bubble_qgrid')->__('Switch Query'),
                    'values'    => $values,
                    'onchange'  => "setLocation(this.value);"
                )
            );
        }

        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend'    => Mage::helper('bubble_qgrid')->__('Query Information')
        ));

        if ($query && $query->getId()) {
            $fieldset->addField('query_id', 'hidden', array(
                'name' => 'query_id',
            ));
        }

        $fieldset->addField('name', 'text',
            array(
                'name'      => 'name',
                'label'     => Mage::helper('bubble_qgrid')->__('Name'),
                'class'     => 'required-entry',
                'required'  => true,
            )
        );

        $fieldset->addField('sql_query', 'textarea',
            array(
                'name'      => 'sql_query',
                'label'     => Mage::helper('bubble_qgrid')->__('SQL Query'),
                'class'     => 'required-entry',
                'required'  => true,
                'style'     => 'width:600px;'
            )
        );

        $fieldset->addField('enable_chart', 'select',
            array(
                'name'      => 'enable_chart',
                'label'     => Mage::helper('bubble_qgrid')->__('Enable Chart'),
                'class'     => 'required-entry',
                'required'  => true,
                'values'    => array(
                    '1' => Mage::helper('adminhtml')->__('Yes'),
                    '0' => Mage::helper('adminhtml')->__('No'),
                ),
            )
        );

        $js = <<<JS
<script type="text/javascript">
//<![CDATA[>
$('enable_chart').observe('change', function() {
    $('chart_type').up('tr').toggle();
});
if ($('enable_chart').value == 0) {
    $('chart_type').up('tr').hide();
}
//]]>
</script>
JS;


        $fieldset->addField('chart_type', 'select',
            array(
                'name'      => 'chart_type',
                'label'     => Mage::helper('bubble_qgrid')->__('Chart Type'),
                'required'  => false,
                'values'    => array(
                    'line'      => Mage::helper('bubble_qgrid')->__('Line'),
                    'spline'    => Mage::helper('bubble_qgrid')->__('Spline'),
                    'column'    => Mage::helper('bubble_qgrid')->__('Column'),
                ),
                'after_element_html' => $js,
            )
        );

        if ($query) {
            $form->addValues($query->getData());
        }
        $form->setAction($this->getUrl('*/*/save'));
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}