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
class Synotive_Allinoneshipping_Block_Adminhtml_Method_Edit_Tab_General extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        
        /* @var $hlp Synotive_Allinoneshipping_Helper_Data */
        $hlp = Mage::helper('synotiveallinoneshipping');
    
        $fldInfo = $form->addFieldset('general', array('legend'=> $hlp->__('General')));
        $fldInfo->addField('name', 'text', array(
            'label'     => $hlp->__('Name'),
            'required'  => true,
            'name'      => 'name',
        ));
        $fldInfo->addField('is_active', 'select', array(
            'label'     => Mage::helper('salesrule')->__('Status'),
            'name'      => 'is_active',
            'options'    => $hlp->getStatuses(),
        ));  
            
       
        $fldInfo->addField('pos', 'text', array(
            'label'     => Mage::helper('salesrule')->__('Priority'), 
            'name'      => 'pos',
        ));
        
        $fldInfo->addField('shipping_cost', 'select', array(
            'label'     => $hlp->__('Shipping Cost Applied'), 
            'name'      => 'shipping_cost',
            'options'    => $hlp->getShippingCost(),
        ));
        
        //set form values
        $form->setValues(Mage::registry('synotiveallinoneshipping_method')->getData()); 
        
        return parent::_prepareForm();
    }
}