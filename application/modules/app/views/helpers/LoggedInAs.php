<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Zend_View_Helper_LoggedInAs extends Zend_View_Helper_Abstract {

    public function loggedInAs() {
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            $username = $auth->getIdentity()->email;
            $logoutUrl = $this->view->url(array('module'=> 'account', 'controller' => 'log', 'action' => 'out'), null, true);
            return  '<h1 class="uk-text-center">Olá ' . $username . ', você está conectado ao nosso sistema.</h1>
                    <h2 class="uk-text-center">Deseja sair? <a href="' . $logoutUrl . '">Sim</a></li>';
        }
    }

}
