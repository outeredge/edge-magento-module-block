<?php

class Edge_Block_Block_Adminhtml_Block_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('blockGrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('block/block')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('id', array(
            'header'    => Mage::helper('block')->__('ID'),
            'width'     => '50',
            'index'     => 'id'
        ));

        $this->addColumn('title', array(
            'header'    => Mage::helper('block')->__('Title'),
            'index'     => 'title'
        ));

        $blockTypes = array(null => '');
        $blockTypeCollection = Mage::getModel('block/type')->getCollection();
        foreach ($blockTypeCollection as $blockType) {
            $blockTypes[$blockType->getId()] = $blockType->getTitle();
        }
        $this->addColumn('type', array(
            'header'    => Mage::helper('block')->__('Type'),
            'index'     => 'type',
            'type'      => 'options',
            'options'   => $blockTypes
        ));

        $this->addColumn('status', array(
            'header'    => Mage::helper('block')->__('Status'),
            'index'     => 'status',
            'width'     => '100',
            'type'     => 'options',
            'options' => array(
                0 => Mage::helper('block')->__('Disabled'),
                1 => Mage::helper('block')->__('Enabled')
            )
        ));

        $this->addColumn('active_from', array(
            'header'    => Mage::helper('block')->__('Active From'),
            'index'     => 'active_from',
            'type'      => 'datetime',
            'width'     => '100px',
        ));

        $this->addColumn('active_to', array(
            'header'    => Mage::helper('block')->__('Active To'),
            'index'     => 'active_to',
            'type'      => 'datetime',
            'width'     => '100px',
        ));

        $this->addColumn('sort_order', array(
            'header'    => Mage::helper('block')->__('Sort Order'),
            'index'     => 'sort_order',
            'width'     => '50'
        ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('block_id' => $row->getId()));
    }
}