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

class Synotive_Allinoneshipping_Block_Adminhtml_Rates extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('synotiveallinoneshippingRates');
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        $id = $this->getRequest()->getParam('id');
        
        $collection = Mage::getResourceModel('synotiveallinoneshipping/rate_collection')
            ->addFieldToFilter('method_id', $id);
   
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('country', array(
            'header'    => Mage::helper('synotiveallinoneshipping')->__('Country'),
            'index'     => 'country',
            'type'      => 'options', 
            'options'   => Mage::helper('synotiveallinoneshipping')->getCountries(),            
        ));

        $this->addColumn('state', array(
            'header'    => Mage::helper('synotiveallinoneshipping')->__('State'),
            'index'     => 'state',
            'type'      => 'options', 
            'options'   => Mage::helper('synotiveallinoneshipping')->getStates(),
        ));

        $this->addColumn('city', array(
            'header'    => Mage::helper('synotiveallinoneshipping')->__('City'),
            'index'     => 'city',
        ));
        
        $this->addColumn('zip_from', array(
            'header'    => Mage::helper('synotiveallinoneshipping')->__('Zip From'),
            'index'     => 'zip_from',
        ));

        $this->addColumn('zip_to', array(
            'header'    => Mage::helper('synotiveallinoneshipping')->__('Zip To'),
            'index'     => 'zip_to',
        ));

        $this->addColumn('price_from', array(
            'header'    => Mage::helper('synotiveallinoneshipping')->__('Price From'),
            'index'     => 'price_from',
        ));
        
        $this->addColumn('price_to', array(
            'header'    => Mage::helper('synotiveallinoneshipping')->__('Price To'),
            'index'     => 'price_to',
        ));
        
        $this->addColumn('weight_from', array(
            'header'    => Mage::helper('synotiveallinoneshipping')->__('Weight From'),
            'index'     => 'weight_from',
        ));
        
        $this->addColumn('weight_to', array(
            'header'    => Mage::helper('synotiveallinoneshipping')->__('Weight To'),
            'index'     => 'weight_to',
        ));         
        
        $this->addColumn('qty_from', array(
            'header'    => Mage::helper('synotiveallinoneshipping')->__('Qty From'),
            'index'     => 'qty_from',
        ));
        
        $this->addColumn('qty_to', array(
            'header'    => Mage::helper('synotiveallinoneshipping')->__('Qty To'),
            'index'     => 'qty_to',
        ));
        
        $this->addColumn('shipping_type', array(
            'header'    => Mage::helper('synotiveallinoneshipping')->__('Shipping Type'),
            'index'     => 'shipping_type',
            'type'      => 'options', 
            'options'   => Mage::helper('synotiveallinoneshipping')->getTypes(),            
        ));
                
        $this->addColumn('cost_base', array(
            'header'    => Mage::helper('synotiveallinoneshipping')->__('Rate'),
            'index'     => 'cost_base',
        ));

        $this->addColumn('action', array(
                'header'    => Mage::helper('catalog')->__('Action'),
                'width'     => '50px',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption' => Mage::helper('catalog')->__('Delete'),
                        'url'     => array('base'=>'*/*/delete'),
                        'field'   => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'is_system' => true,
        )); 
        
        $this->addExportType('*/*/exportCsv', Mage::helper('synotiveallinoneshipping')->__('CSV'));
                
        return parent::_prepareColumns();
    }
     
    public function getRowUrl($row)
    {
        return $this->getUrl('*/adminhtml_rate/edit', array('id' => $row->getId())); 
    }
      
}