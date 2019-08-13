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
class Synotive_Table_Block_Adminhtml_Method_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id'; 
        $this->_blockGroup = 'synotivetable';
        $this->_controller = 'adminhtml_method';
        $this->_removeButton('delete');
        
        $this->_addButton('save_and_continue', array(
                'label'     => Mage::helper('synotivetable')->__('Save and Continue Edit'),
                'onclick'   => 'saveAndContinueEdit()',
                'class' => 'save'
            ), 10);
       
        $mid = Mage::registry('synotivetable_method')->getId();    
        if ($mid) {
            $this->_addButton('new', array(
                    'label' => Mage::helper('synotivetable')->__('Add New Rate'),
                    'onclick' => 'newRate()',
                    'class' => 'add'
                ),15);

            $url = $this->getUrl('*/adminhtml_rate/edit', array('mid'=>$mid));  
            $this->_formScripts[] = " function newRate(){ setLocation('$url'); } ";    
        }    
        $this->_formScripts[] = " function saveAndContinueEdit(){ editForm.submit($('edit_form').action + 'continue/edit') }";       
    }

    public function getHeaderText()
    {
        $model = Mage::registry('synotivetable_method');
        if ($model->getId()){
            $header = Mage::helper('synotivetable')->__('Edit Method `%s`', $model->getName());
        }
        return $header;
    }
}