<?php

class Edge_Block_Block_Adminhtml_Type_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Initialize block edit block
     * @return void
     */
    public function __construct()
    {
        $this->_objectId   = 'block_id';
        $this->_controller = 'adminhtml_type';
        $this->_blockGroup = 'block';

        parent::__construct();

        $this->_updateButton('save', 'label', Mage::helper('block')->__('Save Block Type'));
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save and Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_updateButton('delete', 'label', Mage::helper('block')->__('Delete Block Type'));

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
        if (Mage::registry('block_type')->getId()) {
            return Mage::helper('block')->__("Edit Block Type '%s'", $this->escapeHtml(Mage::registry('block_type')->getTitle()));
        }
        else {
            return Mage::helper('block')->__('New Block Type');
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
