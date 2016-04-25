<?php

class Organization extends Zend_Db_Table {

    protected $_schema = 'public';
    protected $_name = 'enterprise';
    protected $_primary = 'id_enterprise';
    protected $_rowClass = 'Organization';
    
    public function selectTable() {
        $sql = $this->select();        
        return $this->fetchAll($sql)->toArray();        
    }
    
    public function saveTable($_name_organization) {
                        
        $data = array(
            id_organization => md5(uniqid(rand(), true)),
            name_organization => $_name_organization
        );
        
        $result = $this->insert($data);
        
        Zend_Loader::loadClass("UserOrganization");
        $classUserOrganization = new UserOrganization();
        
        return $classUserOrganization->saveTable($result);

    }
    
}