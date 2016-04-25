<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Bills extends Zend_Db_Table {

    protected $_schema = 'finance';
    protected $_name = 'bills';
    protected $_primary = 'id_bills';
    protected $_rowClass = 'Bills';
    
    public function selectTableArchive($type_bills = null) {
        $sql = $this->select()->where("type_bills = ?", $type_bills);
        return $this->fetchAll($sql)->toArray();
    }

    public function selectTable($type_bills = null) {
        $authNamespace = new Zend_Session_Namespace('Teste');
        $sql = $this->select()->where("id_configuration = ?", $authNamespace->configuration)->where("type_bills = ?", $type_bills);
        return $this->fetchAll($sql)->toArray();
    }
    
    public function selectTableb0() {
        $sql = $this->select()->from('finance.bills', array('sum' => 'SUM(value)'))->where("type_bills = ?", "0");
        return $this->fetchAll($sql)->toArray();
    }
    
    public function selectTableb1() {
        $sql = $this->select()->from('finance.bills', array('sum' => 'SUM(value)'))->where('type_bills = ?', '1');
        return $this->fetchAll($sql)->toArray();
    }
    
    public function selectBills($id_bills = null) {
        $sql = $this->select()->where("id_bills = ?", $id_bills);
        return $this->fetchAll($sql)->toArray();
    }
    
    public function saveTable($description, $due_date, $value, $type_bills) {
        $authNamespace = new Zend_Session_Namespace('Teste');
        $data = array(
                    id_bills => md5(uniqid(rand(), true)),
                    description => $description,
                    due_date => $due_date,
                    value => $value,
                    id_configuration => $authNamespace->configuration,
                    type_bills => $type_bills
                );
        
        return $this->insert($data);                 
    }
    
    public function alterTable($id_bills, $description, $due_date, $value) {
        $where = $this->getAdapter()->quoteInto('id_bills = ?', $id_bills);
        $data = array(
            description => $description,
            due_date => $due_date,
            value => $value,
        );
        return $this->update($data, $where);      
    }
    
    public function deleteTable($id = null) {
        $where = $this->getAdapter()->quoteInto('id_bills = ?', $id);
        return $this->delete($where);            
    }
    
}
