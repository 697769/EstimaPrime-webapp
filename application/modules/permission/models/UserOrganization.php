<?php

class UserOrganization extends Zend_Db_Table {

    protected $_schema = 'permission';
    protected $_name = 'user_organization';
    protected $_primary = 'id_user_organization';
    protected $_rowClass = 'UserOrganization';
    
    public function selectTable() {        
        $sql = $this->getAdapter()->select()->from(array("a" => "permission.user_organization"))
                ->joinLeft(array("b" => "account.organization"), "a.id_organization = b.id_organization", array("name_organization"));

        $sql->where("id_user = ?", Zend_Auth::getInstance()->getIdentity()->id_user);

        return $this->getAdapter()->fetchAll($sql);        
    }
    
    public function saveTable($id_organization = null) {
        $authentication = Zend_Auth::getInstance();
        $data = array(
            id_user_organization => md5(uniqid(rand(), true)),
            id_user => $authentication->getIdentity()->id_user,
            id_organization => $id_organization
        );
        return $this->insert($data);     

    }
    
}