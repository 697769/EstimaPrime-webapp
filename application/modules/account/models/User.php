<?php

class User extends Zend_Db_Table {

    protected $_schema = 'public';
    protected $_name = 'user';
    protected $_primary = 'id_user';
    protected $_rowClass = 'User';
        
    public function selectTable($email = null) {
        $sql = $this->select();        
        
        if ($email != null) {
            $sql->where("email = ?", $email);
        }
        
        return $this->fetchAll($sql)->toArray();        
    }
    
    public function saveTable($firstname = null, $lastname = null, $email = null, $password = null) {
        
        $data = array(
            id_user => md5(uniqid(rand(), true)),
            firstname => $firstname,
            lastname => $lastname,
            email => $email,
            password => md5($password),
            verify_code => 1
        );
        
        return $this->insert($data);     

    }
    
}