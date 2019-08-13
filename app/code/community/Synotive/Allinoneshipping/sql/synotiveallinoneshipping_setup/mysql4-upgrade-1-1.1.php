<?php
$installer = $this;
$setup = new Mage_Eav_Model_Entity_Setup('core_setup');
$installer->startSetup();

/**
* ADDING ATTRIBUTE
*/       
$setup->addAttribute('catalog_product', 'synotive_shipping_type', array(
    'type'              => 'varchar',
    'backend'           => 'eav/entity_attribute_backend_array',
    'frontend'          => '',
    'label'             => 'Shipping Type',
    'input'             => 'select',
    'class'             => '',
    'source'            => '',
    'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'visible'           => true,
    'required'          => false,
    'user_defined'      => true,
    'default'           => '0',
    'searchable'        => false,
    'filterable'        => false,
    'comparable'        => false,
    'visible_on_front'  => false,
    'unique'            => false,
    'apply_to'          => '',
    'is_configurable'   => false,   
));
$attributeId = $installer->getAttributeId('catalog_product', 'synotive_shipping_type');

foreach ($installer->getAllAttributeSetIds('catalog_product') as $attributeSetId) 
{
    try {
        $attributeGroupId = $installer->getAttributeGroupId('catalog_product', $attributeSetId, 'General');
    } catch (Exception $e) {
        $attributeGroupId = $installer->getDefaultAttributeGroupId('catalog_product', $attributeSetId);
    }
    $installer->addAttributeToSet('catalog_product', $attributeSetId, $attributeGroupId, $attributeId);
}

$option['attribute_id'] = $attributeId;
$option['value']['Free Shipping'][0] = 'Free Shipping';
$option['value']['Flat Rate'][0] = 'Flat Rate';
$option['value']['Based on Zip/Postal Code'][0] = 'Based on Zip/Postal Code';
$option['value']['Based on Price'][0] = 'Based on Price';
$option['value']['Based on Weight'][0] = 'Based on Weight';
$setup = new Mage_Eav_Model_Entity_Setup('core_setup');
$setup->addAttributeOption($option);

$installer->endSetup();