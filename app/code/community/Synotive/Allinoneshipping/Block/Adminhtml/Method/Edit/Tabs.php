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
class Synotive_Allinoneshipping_Block_Adminhtml_Method_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('methodTabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('synotiveallinoneshipping')->__('All Shipping Methods'));
    }

    protected function _beforeToHtml()
    {
        $tabs = array(
            'general'    => 'General',
            'stores'     => 'Stores & Customer Groups',
            'import'     => 'Import',
        );
        
        foreach ($tabs as $code => $label){
            $label = Mage::helper('synotiveallinoneshipping')->__($label);
            $content = $this->getLayout()->createBlock('synotiveallinoneshipping/adminhtml_method_edit_tab_' . $code)
                ->setTitle($label)
                ->toHtml();
                
            $this->addTab($code, array(
                'label'     => $label,
                'content'   => $content,
            ));
        }
        
        $this->addTab('rates', array(
            'label'     => Mage::helper('synotiveallinoneshipping')->__('Methods and Rates'),
            'class'     => 'ajax',
            'url'       => $this->getUrl('synotiveallinoneshipping/adminhtml_rate/index', array('_current' => true)),
        ));
    
        
        $this->_updateActiveTab();    
    
        return parent::_beforeToHtml();
    }
    
    protected function _updateActiveTab()
    {
    	$tabId = $this->getRequest()->getParam('tab');
    	if ($tabId) {
    		$tabId = preg_replace("#{$this->getId()}_#", '', $tabId);
    		if ($tabId) {
    			$this->setActiveTab($tabId);
    		}
    	}
    	else {
    	   $this->setActiveTab('main'); 
    	}
    }     
 
    
}