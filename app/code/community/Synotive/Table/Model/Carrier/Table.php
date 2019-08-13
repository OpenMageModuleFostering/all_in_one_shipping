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
class Synotive_Table_Model_Carrier_Table extends Mage_Shipping_Model_Carrier_Abstract
{
    protected $_code = 'synotivetable';

    /**
     * Collect rates for this shipping method based on information in $request
     *
     * @param Mage_Shipping_Model_Rate_Request $data
     * @return Mage_Shipping_Model_Rate_Result
     */
    public function collectRates(Mage_Shipping_Model_Rate_Request $request) 
    {
        if (!$this->getConfigData('active')) {
            return false;
        }

        $result = Mage::getModel('shipping/rate_result');
        
        $collection = Mage::getResourceModel('synotivetable/method_collection')
            ->addFieldToFilter('is_active', 1)
            ->addStoreFilter($request->getStoreId())
            ->addCustomerGroupFilter($this->getCustomerGroupId($request))
            ->setOrder('pos'); 
                            
        $rates = Mage::getModel('synotivetable/rate')->findBy($request, $collection); 
        $calculateProductIds = array(); 
        $ratesNew = array();
        $allValues = array(); 
        foreach($rates as $key => $value){
            array_push($calculateProductIds,$key);
            $allValues = $value;            
            foreach($allValues as $key => $value){                
                $ratesNew[$key] += $value;
            }            
        } 
        
        $product_ids = array();
        if ($request->getAllItems()) {
            foreach ($request->getAllItems() as $item) {
                array_push($product_ids,$item->getProductId());                         
            }
        }
        
        $final_prod_ids = array_diff($product_ids,$calculateProductIds);
        $countOfRates = 0; 
        $final = array();
        $total = 0;
        $product_wise_rates = array();
        foreach ($collection as $customMethod){
            
            if (isset($ratesNew[$customMethod->getId()]))
            {
                $i += floatval($ratesNew[$customMethod->getId()]);
                $final[$i]['carrier'] = $this->_code;
                $final[$i]['carrier_title'] = $this->getConfigData('title');                
                $final[$i]['method'] = $this->_code . $customMethod->getId();
                $final[$i]['method_title'] = Mage::helper('synotivetable')->__($customMethod->getName());        
                $final[$i]['cost'] = $ratesNew[$customMethod->getId()];
                $final[$i]['price'] += floatval($ratesNew[$customMethod->getId()]);
                array_push($product_wise_rates,$ratesNew[$customMethod->getId()]);                
                $total += floatval($ratesNew[$customMethod->getId()]);   
                $countOfRates++;
                $j++;
            }
        }
        
        if (($this->getConfigData('showmethod') == 1) && ( !empty($final_prod_ids) )){
            foreach($final_prod_ids as $prod_id)
            {
                $productObj = Mage::getModel('catalog/product')->load($prod_id);
                $error = Mage::getModel('shipping/rate_result_error');
                $error->setCarrier($this->_code);
                $error->setCarrierTitle($this->getConfigData('title'));
                $error->setErrorMessage("'".$productObj->getName(). "' - For the product, shipping method is not available. So please remove that product to procced to checkout.");
                $result->append($error);
            }
        }
        else{
            if(($countOfRates != 0) && ($this->getConfigData('showmethod') == 1))
            {
                $test =  max(array_keys($final));
                $final_ar = $final[$test];
        
                // create new instance of method rate
                $method = Mage::getModel('shipping/rate_result_method');
        
                // record carrier information
                $method->setCarrier($final_ar['carrier']);
                $method->setCarrierTitle($final_ar['carrier_title']);
        
                // record method information
                $method->setMethod($final_ar['method']);
                //$method->setMethodTitle($final_ar['method_title']);
                $product_wise_rates = array_reverse($product_wise_rates);
                $shippingVal = "(";$j = 0;
                foreach($product_wise_rates as $rate)
                {
                    if($j!=0)
                        $shippingVal .= " + ";  
                    
                    $shippingVal .= " $".$rate;
                    $j++;
                }
                $shippingVal .= " )";
                //$product_wise_rates
                $method->setMethodTitle($shippingVal." Total Shipping Costs ");            
                $method->setCost($final_ar['cost']);
                $method->setPrice(round($total,2));
    
                // add this rate to the result
                $result->append($method);
            }
        }        
        return $result;
    } 


    public function getAllowedMethods()
    {
        $collection = Mage::getResourceModel('synotivetable/method_collection')
                ->addFieldToFilter('is_active', 1)
                ->setOrder('pos');
        $arr = array();
        foreach ($collection as $method){
            $methodCode = 'synotivetable'.$method->getMethodId();
            $arr[$methodCode] = $method->getName();    
        }  
                
        return $arr;
    }
    
    public function getCustomerGroupId($request)
    {
        $allItems = $request->getAllItems();
        if (!$allItems){
            return 0;
        }
        foreach ($allItems as $item)
        {
            return $item->getProduct()->getCustomerGroupId();             
        }

    }
}
