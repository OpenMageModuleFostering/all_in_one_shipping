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
class Synotive_Allinoneshipping_Model_Mysql4_Rate extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        $this->_init('synotiveallinoneshipping/rate', 'rate_id');
    }

    public function batchInsert($methodId, $data)
    {
        $err = '';
       
        $sql = '';
        for ($i=0, $n=count($data); $i<$n; ++$i){
            $sql .= ' (NULL,' . $methodId;
            foreach ($data[$i] as $v){
                $sql .= ', "'.$v.'"';
            }
            $sql .= '),';
        } 
        
        if ($sql){

            $sql = 'INSERT INTO `' . $this->getMainTable() . '` VALUES ' . substr($sql, 0, -1);
            try {
                $this->_getWriteAdapter()->raw_query($sql);
            } 
            catch (Exception $e) {
                $err = $e->getMessage();
            }
        }
            
        return $err;
    } 
    
    public function deleteBy($methodId)
    {
        $this->_getWriteAdapter()->delete($this->getMainTable(), 'method_id=' . intVal($methodId)); 
    }     
       
}