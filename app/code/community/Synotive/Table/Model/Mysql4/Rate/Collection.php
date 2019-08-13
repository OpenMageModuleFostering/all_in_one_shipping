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
class Synotive_Table_Model_Mysql4_Rate_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        $this->_init('synotivetable/rate');
    }
    
    public function addAddressFilters($request)
    {
        $this->addFieldToFilter('country', array(
            array(
                'like'  => $request->getDestCountryId(),
            ),
            array(
                'eq'    => '0',
            ),
            array(
                'eq'    => '',
            ),                                                                  
        ));
        
        $this->addFieldToFilter('state', array(
                                array(
                                'like'  => $request->getDestRegionId(),
                                 ),
                                array(
                                'eq'    => '0',
                                 ),
                                array(
                                'eq'    => '',
                                 ),                                                                  
        ));
        
        $this->addFieldToFilter('city', array(
                                array(
                                'like'  => $request->getDestCity(),
                                 ),
                                array(
                                'eq'    => '',
                                 ),                                                                  
        ));
        
        if (Mage::getStoreConfig('carriers/synotivetable/numeric_zip'))
        {
            $this->addFieldToFilter('zip_from', array(
                                    array(
                                    'lteq'  => $request->getDestPostcode(),
                                     ),
                                    array(
                                    'eq'    => '',
                                     ),                                                                  
            ));
            $this->addFieldToFilter('zip_to', array(
                                    array(
                                    'gteq'  => $request->getDestPostcode(),
                                     ),
                                    array(
                                    'eq'    => '',
                                     ),                                                                  
            ));                          
        }
        else
            $this->getSelect()->where("? LIKE zip_from OR zip_from = ''", $request->getDestPostcode());

        return $this;        
    }    
    
    public function addMethodFilters($methodIds)
    {
        $this->addFieldToFilter('method_id', array('in'=>$methodIds));  
                                         
        return $this;    
    } 
       
    public function addTotalsFilters($totals,$shippingType)
    {
        $this->addFieldToFilter('price_from', array('lteq'=>$totals['not_free_price']));
        $this->addFieldToFilter('price_to', array('gteq'=>$totals['not_free_price']));
        $this->addFieldToFilter('weight_from', array('lteq'=>$totals['not_free_weight']));
        $this->addFieldToFilter('weight_to', array('gteq'=>$totals['not_free_weight']));
        $this->addFieldToFilter('qty_from', array('lteq'=>$totals['not_free_qty']));
        $this->addFieldToFilter('qty_to', array('gteq'=>$totals['not_free_qty']));
        $this->addFieldToFilter('shipping_type', array(
                                    array(
                                    'eq'  => $shippingType,
                                     ),
                                    array(
                                    'eq'    => '',
                                     ),
                                    array(
                                    'eq'    => '0',
                                     ),                                                                                                             
            ));                         
        return $this;
        
    }
}