<?php

class Edge_Block_Block_Adminhtml_Block_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Load Wysiwyg on demand and Prepare layout
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
    }

    protected function _prepareForm()
    {
        /** @var $model Edge_Block_Model_Block */
        $model = Mage::registry('block');

        $form = new Varien_Data_Form(array(
            'id'      => 'edit_form',
            'action'  => $this->getData('action'),
            'method'  => 'post',
            'enctype' => 'multipart/form-data'
        ));
        $form->setUseContainer(true);
        $form->setHtmlIdPrefix('block_');

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

        $blockTypes = array(null => '');
        $blockTypeCollection = Mage::getModel('block/type')->getCollection();
        foreach ($blockTypeCollection as $blockType) {
            $blockTypes[$blockType->getId()] = $blockType->getTitle();
        }
        $fieldset->addField('type', 'select', array(
            'label' => Mage::helper('block')->__('Type'),
            'name'  => 'type',
            'options' => $blockTypes
        ));

        $fieldset->addField('image', 'image', array(
            'label' => Mage::helper('block')->__('Image'),
            'name'  => 'image'
        ));

        $fieldset->addField('link', 'text', array(
            'label' => Mage::helper('block')->__('Link'),
            'name'  => 'link'
        ));

        $fieldset->addField('content', 'editor', array(
            'label'  => Mage::helper('block')->__('Content'),
            'name'   => 'content',
            'config' => Mage::getSingleton('cms/wysiwyg_config')->getConfig()
        ));

        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('block')->__('Status'),
            'name'  => 'status',
            'options' => array(
                1 => Mage::helper('block')->__('Enabled'),
                0 => Mage::helper('block')->__('Disabled')
            )
        ));

        $dateFormatIso = Mage::app()->getLocale()->getDateFormat(
            Mage_Core_Model_Locale::FORMAT_TYPE_SHORT
        );

        $fieldset->addField('active_from', 'date', array(
            'name'      => 'active_from',
            'label'     => Mage::helper('block')->__('Active From'),
            'image'     => $this->getSkinUrl('images/grid-cal.gif'),
            'format'    => $dateFormatIso
        ));

        $fieldset->addField('active_to', 'date', array(
            'name'      => 'active_to',
            'label'     => Mage::helper('block')->__('Active To'),
            'image'     => $this->getSkinUrl('images/grid-cal.gif'),
            'format'    => $dateFormatIso
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