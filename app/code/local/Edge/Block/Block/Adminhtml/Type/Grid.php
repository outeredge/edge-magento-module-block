<?php

class Edge_Block_Block_Adminhtml_Type_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('blockTypeGrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('block/type')->getCollection();
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

        $this->addColumn('identifier', array(
            'header'    => Mage::helper('block')->__('Identifier'),
            'index'     => 'identifier',
            'width'     => '200'
        ));

        $this->addColumn('status', array(
            'header'    => Mage::helper('block')->__('Status'),
            'index'     => 'status',
            'width'     => '100',
            'type'      => 'options',
            'options' => array(
                0 => Mage::helper('block')->__('Disabled'),
                1 => Mage::helper('block')->__('Enabled')
            )
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
        return $this->getUrl('*/*/edit', array('block_type_id' => $row->getId()));
    }
}