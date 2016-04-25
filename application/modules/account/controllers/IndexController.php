<?php

class Account_IndexController extends Zend_Controller_Action {

    public function init() {
        if(!Zend_Auth::getInstance()->hasIdentity()){
            $this->_redirect('account/sign/in');
        }
    }

    public function indexAction() {
        $this->view->teste = '<script type="text/javascript" src="/public/modules/account/js/library.userOrganization.js"></script>
                              <script type="text/javascript" src="/public/modules/account/js/library.organization.js"></script>';        
             
    }
    
    public function saveorganizationAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        
        Zend_Loader::loadClass("Organization");
        $_classOrganization = new Organization();
        
        echo $_classOrganization->saveTable($this->_request->getParam("f-input-name"));
        
         
    }
    
    public function redirectconfigurationAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        
        $authNamespace = new Zend_Session_Namespace('Teste');
        $authNamespace->configuration = $_GET['configuration'];
         
        $this->_redirect('app/finance/overview');
    }
    
    public function viewuserorganizationAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        
        $authentication = Zend_Auth::getInstance();
        header('Content-Type: application/json');
        
        Zend_Loader::loadClass("UserOrganization");
        $classUserOrganization = new UserOrganization();
        $arraySelectTable = $classUserOrganization->selectTable($authentication->getIdentity()->id_user);
        foreach ($arraySelectTable as $value) {
            $arrayJson[] = array ( $value['id_user_organization'], $value['id_user'], $value['id_organization'], $value['name_organization'] );
        }
        print_r(Zend_Json::encode($arrayJson));
    }
    
}
