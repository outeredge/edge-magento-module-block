<?php

class Edge_Block_Block_Adminhtml_Type extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_type';
        $this->_blockGroup = 'block';
        $this->_headerText = Mage::helper('block')->__('Manage Block Types');
        $this->_addButtonLabel = Mage::helper('block')->__('Add Block Type');
        parent::__construct();
    }
}
