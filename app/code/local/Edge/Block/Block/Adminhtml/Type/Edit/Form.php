<?php

class Edge_Block_Block_Adminhtml_Type_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        /** @var $model Edge_Block_Model_Type */
        $model = Mage::registry('block_type');

        $form = new Varien_Data_Form(array(
            'id'      => 'edit_form',
            'action'  => $this->getData('action'),
            'method'  => 'post'
        ));
        $form->setUseContainer(true);
        $form->setHtmlIdPrefix('blocktype_');

        $fieldset = $form->addFieldset('content_fieldset', array(
            'legend' => Mage::helper('block')->__('Content'),
            'class'  => 'fieldset-wide'
        ));

        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', array('name' => 'id'));
        }

        $fieldset->addField('title', 'text', array(
            'label' => Mage::helper('block')->__('Title'),
            'name'  => 'title'
        ));

        $fieldset->addField('identifier', 'text', array(
            'label' => Mage::helper('block')->__('Identifier'),
            'name'  => 'identifier'
        ));

        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('block')->__('Status'),
            'name'  => 'status',
            'options' => array(
                1 => Mage::helper('block')->__('Enabled'),
                0 => Mage::helper('block')->__('Disabled')
            )
        ));

        $fieldset->addField('sort_order', 'text', array(
            'label' => Mage::helper('block')->__('Sort Order'),
            'name'  => 'sort_order',
            'class' => 'validate-number'
        ));

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }
}