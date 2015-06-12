<?php

class Edge_Block_Model_Resource_Block extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {
        $this->_init('block/block', 'id');
    }
}
