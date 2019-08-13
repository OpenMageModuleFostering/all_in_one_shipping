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
* @package     Synotive_Table
* @copyright   Copyright (c) 2015 Synotive. 
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Synotive_Table_Block_Adminhtml_Method extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_method';
        $this->_blockGroup = 'synotivetable';
        $this->_headerText = Mage::helper('synotivetable')->__('All in One Shipping');
        parent::__construct();
        $this->_removeButton('add');
    }
}