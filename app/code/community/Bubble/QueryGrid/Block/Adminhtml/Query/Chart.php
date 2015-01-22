<?php
/**
 * @category    Bubble
 * @package     Bubble_QueryGrid
 * @version     1.0.0
 * @copyright   Copyright (c) 2015 BubbleShop (https://www.bubbleshop.net)
 */
class Bubble_QueryGrid_Block_Adminhtml_Query_Chart extends Mage_Adminhtml_Block_Abstract
{
    protected $_colors = array(
        '#2f7ed8', '#8bbc21', '#910000', '#1aadce', '#492970', '#f28f43', '#77a1e5', '#c42525', '#a6c96a',
    );

    public function getQuery()
    {
        return Mage::registry('query_grid');
    }

    public function isEnabled()
    {
        return $this->getQuery() && $this->getQuery()->getEnableChart();
    }

    public function getChartType()
    {
        return $this->getQuery()->getChartType();
    }

    public function getResults()
    {
        try {
            return $this->getQuery()->getResults();
        } catch (Exception $e) {
            Mage::logException($e);
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }

        return array();
    }

    public function getLocaleCode()
    {
        return Mage::app()->getLocale()->getLocaleCode();
    }

    public function getFormatOptions()
    {
        return Zend_Locale_Data::getList($this->getLocaleCode(), 'symbols');
    }

    public function getTitle()
    {
        return $this->getQuery()->getName();
    }

    public function getCurrentColor()
    {
        $color = current($this->_colors);
        if (!next($this->_colors)) {
            reset($this->_colors);
        }

        return $color;
    }

    public function getSeries()
    {
        $series = array();
        $results = $this->getResults();
        if (!empty($results)) {
            $keys = array_slice(array_keys($results[0]), 1);
            foreach ($keys as $key) {
                $data = array();
                foreach (array_reverse($results) as $row) {
                    $data[] = (float) $row[$key];
                }
                $series[] = array(
                    'name'  => $this->formatLabel($key),
                    'data'  => $data,
                    'color' => $this->getCurrentColor(),
                );
            }
        }

        return $series;
    }

    public function getValuesX()
    {
        $values = array();
        foreach (array_reverse($this->getResults()) as $row) {
            $values[] = reset($row);
        }

        return $values;
    }

    public function getThousandSeparator()
    {
        $options = $this->getFormatOptions();

        return $options['group'];
    }

    public function getDecimalPoint()
    {
        $options = $this->getFormatOptions();

        return $options['decimal'];
    }

    public function formatLabel($label)
    {
        return uc_words($label, ' ');
    }
}