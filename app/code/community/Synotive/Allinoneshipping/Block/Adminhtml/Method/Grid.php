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
class Synotive_Allinoneshipping_Block_Adminhtml_Method_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('methodGrid');
      $this->setDefaultSort('pos');
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('synotiveallinoneshipping/method')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
    $hlp =  Mage::helper('synotiveallinoneshipping'); 
    $this->addColumn('method_id', array(
      'header'    => $hlp->__('ID'),
      'align'     => 'right',
      'width'     => '50px',
      'index'     => 'method_id',
    ));

    $this->addColumn('name', array(
        'header'    => $hlp->__('Name'),
        'index'     => 'name',
    ));
    
    $this->addColumn('pos', array(
        'header'    => $hlp->__('Priority'),
        'index'     => 'pos',
    ));    
    
    $this->addColumn('is_active', array(
        'header'    => Mage::helper('salesrule')->__('Status'),
        'align'     => 'left',
        'width'     => '80px',
        'index'     => 'is_active',
        'type'      => 'options',
        'options'   => $hlp->getStatuses(),
    ));    
    
    $this->addColumn('shipping_cost', array(
        'header'    => $hlp->__('Shipping Cost'),
        'align'     => 'left',
        'width'     => '100px',
        'index'     => 'shipping_cost',
        'type'      => 'options',
        'options'   => $hlp->getShippingCost(),
    )); 
    
    return parent::_prepareColumns();
  }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }
  
  protected function _prepareMassaction()
  {
    $this->setMassactionIdField('method_id');
    $this->getMassactionBlock()->setFormFieldName('methods');
    
    $actions = array(
        'massActivate'   => 'Activate',
        'massInactivate' => 'Inactivate',
    );
    foreach ($actions as $code => $label){
        $this->getMassactionBlock()->addItem($code, array(
             'label'    => Mage::helper('synotiveallinoneshipping')->__($label),
             'url'      => $this->getUrl('*/*/' . $code),            
        ));        
    }
    return $this; 
  }
}