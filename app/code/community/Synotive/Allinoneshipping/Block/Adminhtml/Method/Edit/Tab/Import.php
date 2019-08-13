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
class Synotive_Allinoneshipping_Block_Adminhtml_Method_Edit_Tab_Import extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        //create form structure
        $form = new Varien_Data_Form();
        $this->setForm($form);
        
        $hlp = Mage::helper('synotiveallinoneshipping');
        
        $fldSet = $form->addFieldset('synotiveallinoneshipping_import', array('legend'=> $hlp->__('Import Rates')));
        $fldSet->addField('import_clear', 'select', array(
          'label'     => $hlp->__('Delete Existing Rates'),
          'name'      => 'import_clear',
          'values'    => array(
            array(
                'value' => 0,
                'label' => Mage::helper('catalog')->__('No')
            ),
            array(
                'value' => 1,
                'label' => Mage::helper('catalog')->__('Yes')
            ))
        ));
        $fldSet->addField('import_file', 'file', array(
          'label'     => $hlp->__('CSV File'),
          'name'      => 'import_file',
          'note'      => $hlp->__('Example file on zip - demo.csv')
        ));               

        return parent::_prepareForm();
    }
}