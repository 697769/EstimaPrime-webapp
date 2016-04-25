<?php

class App_IndexController extends Zend_Controller_Action {

    public function init() {
        if(!Zend_Auth::getInstance()->hasIdentity()){
            $this->_redirect('account/log/in');
        }
    }

    public function indexAction() {
        
    }
        
}
