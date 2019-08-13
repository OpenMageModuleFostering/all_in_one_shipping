<?php
 /**
* Synotive
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
*
* @category    Synotive
* @package     Synotive_Allinoneshipping
* @copyright   Copyright (c) 2015 Synotive. 
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Synotive_Allinoneshipping_Model_Mysql4_Method extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        $this->_init('synotiveallinoneshipping/method', 'method_id');
    }          
}