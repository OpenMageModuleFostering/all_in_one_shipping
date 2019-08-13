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
class Synotive_Table_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getAllGroups()
    {
        $customerGroups = Mage::getResourceModel('customer/group_collection')
            ->load()->toOptionArray();

        $found = false;
        foreach ($customerGroups as $group) {
            if ($group['value']==0) {
                $found = true;
            }
        }
        if (!$found) {
            array_unshift($customerGroups, array('value'=>0, 'label'=>Mage::helper('salesrule')->__('NOT LOGGED IN')));
        } 
        
        return $customerGroups;
    }
    
    public function getStatuses()
    {
        return array(
            '0' => $this->__('Inactive'),
            '1' => $this->__('Active'),
        );       
    }
    
    public function getShippingCost()
    {
        return array(
            'Per Order' => $this->__('Per Order'),
            'Per Product' => $this->__('Per Product'),
        );
    }  
      
    public function getStates()
    {
        $hash = array();
        $hashCountry = $this->getCountries();
        
        $collection = Mage::getResourceModel('directory/region_collection')->getData();

        foreach ($collection as $state){
            $hash[$state['region_id']] = $hashCountry[$state['country_id']] ."/".$state['default_name'];
        }
        asort($hash);
        $hashAll['0'] = 'All';
        $hash = $hashAll + $hash;        
        return $hash;    
    }
        
    public function getCountries()
    {
        $hash = array();
        $countries = Mage::getModel('directory/country')->getCollection()->toOptionArray();

        foreach ($countries as $country){
            if($country['value']){
                $hash[$country['value']] = $country['label'];                
            }
        }
        asort($hash);
        $hashAll['0'] = 'All';
        $hash = $hashAll + $hash; 
        return $hash;    
    } 
   
    public function getTypes()
    {
        $hash = array();
        $attribute = Mage::getSingleton('eav/config')->getAttribute('catalog_product', 'synotive_shipping_type');
        if ($attribute->usesSource()) {
            $options = $attribute->getSource()->getAllOptions(false);
        }
        foreach ($options as $option){
            $hash[$option['value']] = $option['label'];    
        }
        asort($hash);
        $hashAll['0'] = 'All';
        $hash = $hashAll + $hash;         
        return $hash;
    }    
}
