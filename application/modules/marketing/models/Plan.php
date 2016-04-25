<?php

class Plan extends Zend_Db_Table {

    protected $_schema = 'marketing';
    protected $_name = 'plan';
    protected $_primary = 'id_plan';
    protected $_rowClass = 'Plan';
    
    public function selectTable() {
        $sql = $this->select();        
        return $this->fetchAll($sql)->toArray();        
    }
    
}