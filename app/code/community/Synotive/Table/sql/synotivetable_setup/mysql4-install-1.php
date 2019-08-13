<?php
$installer = $this;  //Getting Installer Class Object In A Variable
$installer->startSetup();
$installer->run("

CREATE TABLE `{$this->getTable('synotivetable/method')}` (
  `method_id`  mediumint(8) unsigned NOT NULL auto_increment,
  `is_active`   tinyint(1) unsigned NOT NULL default '0',
  `pos`         mediumint  unsigned NOT NULL default '0',
  `name`        varchar(255) default '', 
  `stores`      varchar(255) NOT NULL default '', 
  `cust_groups` varchar(255) NOT NULL default '',
  `shipping_cost` ENUM( 'Per Order', 'Per Product' ) NULL default 'Per Order',
  PRIMARY KEY  (`method_id`)  
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `{$this->getTable('synotivetable/method')}` (`is_active`, `pos`, `name`, `stores`, `cust_groups`, `shipping_cost`) VALUES ('0','1','Free Shipping Method','1','0,1,2,3','Per Order');
INSERT INTO `{$this->getTable('synotivetable/method')}` (`is_active`, `pos`, `name`, `stores`, `cust_groups`, `shipping_cost`) VALUES ('0','2','Flat Rate Shipping Method','1','0,1,2,3','Per Order');
INSERT INTO `{$this->getTable('synotivetable/method')}` (`is_active`, `pos`, `name`, `stores`, `cust_groups`, `shipping_cost`) VALUES ('0','3','Based on Zip/Postal Code Shipping Method','1','0,1,2,3','Per Order');
INSERT INTO `{$this->getTable('synotivetable/method')}` (`is_active`, `pos`, `name`, `stores`, `cust_groups`, `shipping_cost`) VALUES ('0','4','Based on Price Shipping Method','1','0,1,2,3','Per Order');
INSERT INTO `{$this->getTable('synotivetable/method')}` (`is_active`, `pos`, `name`, `stores`, `cust_groups`, `shipping_cost`) VALUES ('0','5','Based on Weight Shipping Method','1','0,1,2,3','Per Order');

CREATE TABLE `{$this->getTable('synotivetable/rate')}` (
  `rate_id`     int(10) unsigned NOT NULL auto_increment,
  `method_id`   mediumint(8) unsigned NOT NULL,
 
  `country`     varchar(4)  NOT NULL default '',
  `state`       int(10)     NOT NULL default '0',  
  `city`        varchar(12) NOT NULL default '',  
  
  `zip_from`    varchar(10) NOT NULL default '',
  `zip_to`      varchar(10) NOT NULL default '', 
  
  `price_from`  decimal(12,2) unsigned NOT NULL default '0',
  `price_to`    decimal(12,2) unsigned NOT NULL default '0',

  `weight_from` decimal(12,4) unsigned NOT NULL default '0',
  `weight_to`   decimal(12,4) unsigned NOT NULL default '0',

  `qty_from`    int(10) unsigned NOT NULL default '0',
  `qty_to`      int(10) unsigned NOT NULL default '0', 
  
  `cost_base`      decimal(12,2) unsigned NOT NULL default '0',
  
  PRIMARY KEY  (`rate_id`),
  UNIQUE KEY(`method_id`, `country`, `state` , `city`, `zip_from`, `zip_to`,  `price_from`, `price_to`, `weight_from`, `weight_to`, `qty_from`, `qty_to`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE  `{$this->getTable('synotivetable/rate')}`  ADD  `shipping_type` INT( 10 ) NOT NULL DEFAULT '0' AFTER  `qty_to`;

ALTER TABLE  `{$this->getTable('synotivetable/rate')}` DROP INDEX  `method_id` ,
ADD UNIQUE  `method_id` (  `method_id` ,  `country` ,  `state` ,  `city` ,  `zip_from` ,  `zip_to` ,  `price_from` ,  `price_to` ,  `weight_from` ,  `weight_to` ,  `qty_from` ,  `qty_to` ,  `shipping_type` );

");

$installer->endSetup();
