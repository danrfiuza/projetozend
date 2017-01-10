<?php

class MunicipioController extends Zend_Controller_Action
{
    public function carregarMunicipioAction()
    {
        $this->_helper->layout->disableLayout();
        
        $dados = $this->_getAllParams();
        $mMunicipio = new Application_Model_Municipio();
        $this->view->municipio = $mMunicipio->fetchAll("id_uf = '{$dados['id_uf']}'",'nome');
    
    }
}

