<?php

class Edge_Block_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getAllBlocks()
    {
        return Mage::getModel('block/block')
            ->getCollection()
            ->addActiveFilter()
            ->setOrder('sort_order', 'ASC');
    }

    public function getBlocksByType($value, $attribute='identifier')
    {
        $blockType = Mage::getModel('block/type')->load($value, $attribute);

        return Mage::getModel('block/block')
            ->getCollection()
            ->addActiveFilter()
            ->addFieldToFilter('type', array('eq' => $blockType->getId()))
            ->setOrder('sort_order', 'ASC');
    }

    public function getBlockByTitle($title)
    {
        return Mage::getModel('block/block')
            ->getCollection()
            ->addActiveFilter()
            ->addFieldToFilter('title', array('eq' => $title))
            ->getFirstItem();
    }

    public function getAllBlockTypes()
    {
        return Mage::getModel('block/type')
            ->getCollection()
            ->addActiveFilter()
            ->setOrder('sort_order', 'ASC');
    }

    public function getBlockType($value, $attribute='identifier')
    {
        return Mage::getModel('block/type')
            ->getCollection()
            ->addActiveFilter()
            ->addFieldToFilter($attribute, array('eq' => $value))
            ->getFirstItem();
    }
}