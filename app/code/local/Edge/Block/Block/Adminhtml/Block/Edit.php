<?php

class Edge_Block_Block_Adminhtml_Block_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Initialize block edit block
     * @return void
     */
    public function __construct()
    {
        $this->_objectId   = 'block_id';
        $this->_controller = 'adminhtml_block';
        $this->_blockGroup = 'block';

        parent::__construct();

        $this->_updateButton('save', 'label', Mage::helper('block')->__('Save Block'));
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save and Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_updateButton('delete', 'label', Mage::helper('block')->__('Delete Block'));

        $this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    /**
     * Retrieve text for header element depending on loaded page
     * @return string
     */
    public function getHeaderText()
    {
        if (Mage::registry('block')->getId()) {
            return Mage::helper('block')->__("Edit Block '%s'", $this->escapeHtml(Mage::registry('block')->getTitle()));
        }
        else {
            return Mage::helper('block')->__('New Block');
        }
    }

    /**
     * Get form action URL
     * @return string
     */
    public function getFormActionUrl()
    {
        if ($this->hasFormActionUrl()) {
            return $this->getData('form_action_url');
        }
        return $this->getUrl('*/*/save');
    }
}
