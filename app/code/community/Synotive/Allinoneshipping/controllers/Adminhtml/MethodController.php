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
class Synotive_Allinoneshipping_Adminhtml_MethodController extends Mage_Adminhtml_Controller_Action
{
    protected $_title     = 'All in One Shipping';
    protected $_modelName = 'method';
    
    protected function _setActiveMenu($menuPath)
    {
        $this->getLayout()->getBlock('menu')->setActive($menuPath);
        $this->_title($this->__('Sales'))->_title($this->__($this->_title));	 
        return $this;
    } 
    
    public function indexAction()
    {
	    $this->loadLayout(); 
        $this->_setActiveMenu('sales/synotiveallinoneshipping/' . $this->_modelName . 's');
        $this->_addContent($this->getLayout()->createBlock('synotiveallinoneshipping/adminhtml_' . $this->_modelName)); 	    
 	    $this->renderLayout();
    }

	public function newAction() 
	{
        $this->editAction();
	}
	
    public function editAction() 
    {
		$id     = (int) $this->getRequest()->getParam('id');
		$model  = Mage::getModel('synotiveallinoneshipping/' . $this->_modelName)->load($id);

		if ($id && !$model->getId()) {
    		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('synotiveallinoneshipping')->__('Record does not exist'));
			$this->_redirect('*/*/');
			return;
		}
		
		$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
		if (!empty($data)) {
			$model->setData($data);
		}
		else {
		    $this->prepareForEdit($model);
		}
		
		Mage::register('synotiveallinoneshipping_' . $this->_modelName, $model);

		$this->loadLayout();
		
		$this->_setActiveMenu('sales/synotiveallinoneshipping/' . $this->_modelName . 's');
		$this->_title($this->__('Edit'));
		
        $this->_addContent($this->getLayout()->createBlock('synotiveallinoneshipping/adminhtml_' . $this->_modelName . '_edit'));
        $this->_addLeft($this->getLayout()->createBlock('synotiveallinoneshipping/adminhtml_' . $this->_modelName . '_edit_tabs'));
        
		$this->renderLayout();
	}

	public function saveAction() 
	{
	    $id     = $this->getRequest()->getParam('id');
	    $model  = Mage::getModel('synotiveallinoneshipping/' . $this->_modelName);
	    $data = $this->getRequest()->getPost();
		if ($data) {
		    $model->setData($data);
			$model->setId($id);
			try {
			    $this->prepareForSave($model);
			    
				$model->save();
				
				if ($model->getData('import_clear')){
				    Mage::getModel('synotiveallinoneshipping/rate')->deleteBy($model->getId());
				}
				
                // import files
                if (!empty($_FILES['import_file']['name'])){
                    $fileName = $_FILES['import_file']['tmp_name'];        
                    ini_set('auto_detect_line_endings', 1); 
                    
                    $errors = Mage::getModel('synotiveallinoneshipping/rate')->import($model->getId(), $fileName);
                    foreach ($errors as $err){
                         Mage::getSingleton('adminhtml/session')->addError($err);
                    }
                }
				
				Mage::getSingleton('adminhtml/session')->setFormData(false);
				
				$msg = Mage::helper('synotiveallinoneshipping')->__('Shipping rates have been successfully saved');
                Mage::getSingleton('adminhtml/session')->addSuccess($msg);
                if ($this->getRequest()->getParam('continue')){
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                }
                else {
                    $this->_redirect('*/*');
                }
            } 
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $id));
            }	
            return;
        }
        
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('synotiveallinoneshipping')->__('Unable to find a record to save'));
        $this->_redirect('*/*');
	} 
	
    public function massActivateAction()
    {
        return $this->_modifyStatus(1);
    }
    
    public function massInactivateAction()
    {
        return $this->_modifyStatus(0);
    }     
    
    protected function _modifyStatus($status)
    {
        $ids = $this->getRequest()->getParam('methods');
        if ($ids && is_array($ids)){
            try {
                Mage::getModel('synotiveallinoneshipping/' . $this->_modelName)->massChangeStatus($ids, $status);
                $message = $this->__('Total of %d record(s) have been updated.', count($ids));
                $this->_getSession()->addSuccess($message);
            } 
            catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        else {
            $this->_getSession()->addError($this->__('Please select method(s).'));
        }
        
        return $this->_redirect('*/*');
    }     
    
    public function prepareForSave($model)
    {
        $fields = array('stores', 'cust_groups');
        foreach ($fields as $f){
            // convert data from array to string
            $val = $model->getData($f);
            $model->setData($f, '');
            if (is_array($val)){
                // need commas to simplify sql query
                $model->setData($f, ',' . implode(',', $val) . ',');    
            } 
        }
        return true;
    }
    
    public function prepareForEdit($model)
    {
        $fields = array('stores', 'cust_groups');
        foreach ($fields as $f){
            $val = $model->getData($f);
            if (!is_array($val)){
                $model->setData($f, explode(',', $val));    
            }        
        }
        return true;
    }
    
    protected function _title($text = null, $resetIfExists = true)
    { 
       /* if (Mage::helper('synotivebase')->isVersionLessThan(1,4)){
            return $this;
        }*/
        return parent::_title($text, $resetIfExists);
    }     
}