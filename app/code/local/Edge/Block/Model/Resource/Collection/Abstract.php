<?php

class Edge_Block_Model_Resource_Collection_Abstract extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    public function addActiveFilter()
    {
        $this->addFieldToFilter('status', array('eq' => true));

        // Add Active From/To Dates
        if ($this instanceof Edge_Block_Model_Resource_Block_Collection) {
            $this->addFieldToFilter('active_from', array(
                     array('to' => Mage::getModel('core/date')->gmtDate()),
                     array('active_from', 'null' => '')
                 ))
                 ->addFieldToFilter('active_to', array(
                     array('gteq' => Mage::getModel('core/date')->gmtDate()),
                     array('active_to', 'null' => '')
                 ));
        }

        return $this;
    }
}
