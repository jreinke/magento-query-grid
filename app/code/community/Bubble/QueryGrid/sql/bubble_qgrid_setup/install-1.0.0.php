<?php
/**
 * @category    Bubble
 * @package     Bubble_QueryGrid
 * @version     1.0.0
 * @copyright   Copyright (c) 2015 BubbleShop (https://www.bubbleshop.net)
 */
/**
 * @var $this Mage_Eav_Model_Entity_Setup
 */
$installer = $this;
$installer->startSetup();

$table = $installer->getTable('bubble_query_grid');

$installer->run("
    DROP TABLE IF EXISTS `{$table}`;
    CREATE TABLE `{$table}` (
        `query_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `name` VARCHAR(255) NOT NULL,
        `sql_query` LONGTEXT NOT NULL,
        `enable_chart` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
        `chart_type` VARCHAR(20) NOT NULL DEFAULT 'line'
    ) ENGINE=INNODB CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT='Bubble Query Grid';
");

$installer->endSetup();
