<?php

class App_FinanceController extends Zend_Controller_Action {

    public function init() {
        if(!Zend_Auth::getInstance()->hasIdentity()){
            $this->_redirect('account/log/in');
        }
    }
    
    public function overviewAction() {
        
        $this->_helper->layout->setLayout('layout_app');
    }
    
    public function billsAction() {
        
        $this->_helper->layout->setLayout('layout_app');
        Zend_Loader::loadClass("Bills");
        $classBills = new Bills();
        $arraySelectTable = $classBills->selectTable('0');
        foreach ($arraySelectTable as $value) {
            $this->view->trTable.= '<tr id="' . $value['id_bills'] . '">'
                    . '<td class=""><input type="checkbox" value="' . $value['id_bills'] . '" /></td>'
                    . '<td class="uk-width-5-10">' . $value['description'] . '</td>'
                    . '<td class="uk-width-3-10">' . $value['due_date'] . '</td>'
                    . '<td class="uk-width-2-10">' . $value['value'] . '</td>'
                    . '</tr>';
        }
        
        $arraySelectTableb0 = $classBills->selectTableb0();
        foreach ($arraySelectTableb0 as $value) {
            $_value_b0 = $value['sum'];
        }
        
        $arraySelectTableb1 = $classBills->selectTableb1();
        foreach ($arraySelectTableb1 as $value) {
            $_value_b1 = $value['sum'];
        }
        
        $_value_01 = floatval(preg_replace('/[^\d\.]/', '', $_value_b0));
        $_value_02 = floatval(preg_replace('/[^\d\.]/', '', $_value_b1));
        
        $_soma = $_value_02 - $_value_01;
        $this->view->soma = "Contas a Pagar + Contas a Receber: " . number_format($_value_01, 2, ',', '.') . " + " . number_format($_value_02, 2, ',', '.') . " = " . number_format($_soma, 2, ',', '.');
        
        $this->view->teste = '<script type="text/javascript" src="/public/modules/app/js/library.bills.js"></script>';
        
    }
    
    public function arquivoAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        
        $filename = 'nome_do_arquivo.csv';
        header('Content-type: text/plain');
        header("Content-Disposition: attachment; filename=\"" . $filename . "\"");
        
        Zend_Loader::loadClass("Bills");
        $classBills = new Bills();
        $arraySelectTable = $classBills->selectTableArchive('1');
        echo "\"DATE\",\"VALOR\"\r\n";
        foreach ($arraySelectTable as $value) {            
            echo $value['due_date'] . "," . number_format(substr($value['value'], 1), 2, '.', '') . "\r\n";    
        }
    }
    
    public function selectAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $this->getResponse()->setHeader('Content-Type', 'application/json');
         Zend_Loader::loadClass("Bills");
        $classBills = new Bills();
        $arraySelectBills = $classBills->selectBills($this->_request->getParam("id_bills"));
        foreach ($arraySelectBills as $value) {
            $array[] = array(
                id_bills => $value["id_bills"],
                description => $value["description"],
                due_date => $value["due_date"],
                value => $value["value"]
            );
        }
        
        print_r(Zend_Json::encode($array));
    }
    
    public function insertAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        Zend_Loader::loadClass("Bills");
        $classBills = new Bills();
        
        if ($this->_request->getParam("id") != "") {
            echo $classBills->alterTable(
                $this->_request->getParam("id"),
                $this->_request->getParam("description"),
                $this->_request->getParam("due_date"),
                $this->_request->getParam("value")
            ); 
        } else {  
            echo $classBills->saveTable(
                $this->_request->getParam("description"),
                $this->_request->getParam("due_date"),
                $this->_request->getParam("value"), 
                '0'
            );   
        }
        
    }
    
    public function insertreceberAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        Zend_Loader::loadClass("Bills");
        $classBills = new Bills();
        
        if ($this->_request->getParam("id") != "") {
            echo $classBills->alterTable(
                $this->_request->getParam("id"),
                $this->_request->getParam("description"),
                $this->_request->getParam("due_date"),
                $this->_request->getParam("value")
            ); 
        } else {  
            echo $classBills->saveTable(
                $this->_request->getParam("description"),
                $this->_request->getParam("due_date"),
                $this->_request->getParam("value"), 
                '1'
            );   
        }  
    }
    
    public function deleteAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        Zend_Loader::loadClass("Bills");
        $classBills = new Bills();
        echo $classBills->deleteTable($this->_request->getParam("id_bills"));    
    }
    
}
