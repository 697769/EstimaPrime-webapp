<?php

class Account_SignController extends Zend_Controller_Action {

    public function init() {
        
    }

    public function inAction() {
        $this->view->teste =    '<script type="text/javascript" src="/public/modules/account/js/library.signin.js"></script>' .
                                '<script type="text/javascript" src="/public/framework/js/components/tooltip.min.js"></script>';
        if (Zend_Auth::getInstance()->hasIdentity()) {
            $this->_helper->redirector('index', 'index');
        } else {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if ($this->process($_POST["username"], $_POST["password"])) {
                    $this->_helper->redirector('index', 'index');
                }
            }
        }
    }
    
    public function doneAction() {
        
    }

    public function upAction() {
        $this->view->teste =    '<script type="text/javascript" src="/public/modules/account/js/library.signup.js"></script>' .
                                '<script type="text/javascript" src="/public/framework/js/components/tooltip.min.js"></script>';
    }

    public function saveAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        Zend_Loader::loadClass("User");
        $classUser = new User();

        $firstname = $this->_request->getParam("f-input-firstname");
        $lastname = $this->_request->getParam("f-input-lastname");
        $email = $this->_request->getParam("f-input-email");
        $password = $this->_request->getParam("f-input-password");        

        try {
            print_r(Zend_Json::encode($classUser->saveTable($firstname, $lastname, $email, $password)));
        } catch (Exception $exc) {
            switch ($exc->getCode()) {
                case 23505:
                    print_r(Zend_Json::encode('duplicate'));
                    break;

                case 23502:
                    print_r(Zend_Json::encode('null'));
                    break;
                
                default:
                    print_r(Zend_Json::encode('unknown'));
                    break;
            }
        }
    
    }
    
    public function sendAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $config = array(
            'auth' => 'login',
            'username' => 'acscrz@gmail.com',
            'password' => '@aj2905.',
            'ssl' => 'ssl',
            'port' => '465'
        );

        $transporte = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $config);
        Zend_Mail::setDefaultTransport($transporte);
        $emailSend = new Zend_Mail('UTF-8');
        $emailSend->setBodyHtml('Conta criada!');
        $emailSend->setFrom('acscrz@gmail.com', 'LOCALHOST');
        $emailSend->addTo('acscrz@gmail.com', 'acscrz@gmail.com');
        $emailSend->setSubject('Conta Criada');
        $result_send = $emailSend->send($transporte);
        if ($result_send) {
            echo 'cadastrado com sucesso';
        } else {
            echo 'false';
        }
    }
    
    public function loggingAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        
        $email = $this->_request->getParam("f-input-email");
        $password = $this->_request->getParam("password");
        
        print_r(Zend_Json::encode($this->process($email, $password)));
        
    }

    protected function process($username, $password) {
        $adapter = $this->getAuthAdapter();
        $adapter->setIdentity($username);
        //$adapter->setCredentiasl(md5($password));
        $adapter->setCredential($password);

        $auth = Zend_Auth::getInstance();
        $result = $auth->authenticate($adapter);
        if ($result->isValid()) {
            $user = $adapter->getResultRowObject();
            $auth->getStorage()->write($user);
            return true;
        } else {
            return false;
        }
    }

    protected function getAuthAdapter() {
        $dbAdapter = Zend_Db_Table::getDefaultAdapter();
        $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);

        $authAdapter->setTableName('public.user')
                ->setIdentityColumn('email')
                ->setCredentialColumn('password');

        return $authAdapter;
    }

    public function outAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        Zend_Auth::getInstance()->clearIdentity();
        $this->_helper->redirector('index', 'index');
    }
    
    public function forgotAction() {
        
    }

}


