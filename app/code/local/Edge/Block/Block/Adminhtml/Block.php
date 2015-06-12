<?php

class Edge_Block_Block_Adminhtml_Block extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_block';
        $this->_blockGroup = 'block';
        $this->_headerText = Mage::helper('block')->__('Block');
        $this->_addButtonLabel = Mage::helper('block')->__('Add Block');
        parent::__construct();
    }
}
