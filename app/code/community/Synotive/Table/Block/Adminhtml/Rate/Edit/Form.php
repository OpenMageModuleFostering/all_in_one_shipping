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
class Synotive_Table_Block_Adminhtml_Rate_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
        //create form structure
        $form = new Varien_Data_Form(array(
          'id' => 'edit_form',
          'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
          'method' => 'post',
         ));
        
        $form->setUseContainer(true);
        $this->setForm($form);
        
        $hlp   = Mage::helper('synotivetable');
        $model = Mage::registry('synotivetable_rate');
        
        $fldDestination = $form->addFieldset('destination', array('legend'=> $hlp->__('Destination')));
        
        $fldDestination->addField('method_id', 'hidden', array(
          'name'      => 'method_id',
        ));        
        
        $fldDestination->addField('country', 'select', array(
          'label'     => $hlp->__('Country'),
          'name'      => 'country',
          'options'   => Mage::helper('synotivetable')->getCountries(), 
        ));
        
        $fldDestination->addField('state', 'select', array(
          'label'     => $hlp->__('State'),
          'name'      => 'state',
          'options'   => Mage::helper('synotivetable')->getStates(), 
        ));
        
        $fldDestination->addField('city', 'text', array(
          'label'     => $hlp->__('City'),
          'name'      => 'city',
        ));
        
        $fldDestination->addField('zip_from', 'text', array(
          'label'     => $hlp->__('Zip From'),
          'name'      => 'zip_from',
        ));

        $fldDestination->addField('zip_to', 'text', array(
          'label'     => $hlp->__('Zip To'),
          'name'      => 'zip_to',
        ));        
                              
        $fldTotals = $form->addFieldset('conditions', array('legend'=> $hlp->__('Conditions')));
        $fldTotals->addField('weight_from', 'text', array(
            'label'     => $hlp->__('Weight From'),
            'name'      => 'weight_from',
        ));
        $fldTotals->addField('weight_to', 'text', array(
            'label'     => $hlp->__('Weight To'),
            'name'      => 'weight_to',
        ));
        
        $fldTotals->addField('qty_from', 'text', array(
            'label'     => $hlp->__('Qty From'),
            'name'      => 'qty_from',
        ));
        $fldTotals->addField('qty_to', 'text', array(
            'label'     => $hlp->__('Qty To'),
            'name'      => 'qty_to',
        ));
        
        $fldTotals->addField('shipping_type', 'select', array(
            'label'     => $hlp->__('Shipping Type'),
            'name'      => 'shipping_type',
            'options'   => Mage::helper('synotivetable')->getTypes(), 
        ));            
        
        $fldTotals->addField('price_from', 'text', array(
            'label'     => $hlp->__('Price From'),
            'name'      => 'price_from',
            'note'      => $hlp->__('Original product cart price, without discounts.'),
        ));
        
        $fldTotals->addField('price_to', 'text', array(
            'label'     => $hlp->__('Price To'),
            'name'      => 'price_to',
            'note'      => $hlp->__('Original product cart price, without discounts.'),
        ));         
        
        
        $fldRate = $form->addFieldset('rate', array('legend'=> $hlp->__('Rate')));
        $fldRate->addField('cost_base', 'text', array(
          'label'     => $hlp->__('Base Rate for the Order'),
          'name'      => 'cost_base',
        ));
                        
        //set form values
        $data = Mage::getSingleton('adminhtml/session')->getFormData();
        if ($data) {
            $form->setValues($data);
            Mage::getSingleton('adminhtml/session')->setFormData(null);
        }
        elseif ($model) {
            $form->setValues($model->getData());
        }
        
        return parent::_prepareForm();
  }
}