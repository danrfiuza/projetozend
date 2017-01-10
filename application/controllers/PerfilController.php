<?php

class PerfilController extends Zend_Controller_Action
{

    public function indexAction()
    {
        
        $page = $this->_getParam('page', 1);
        
        $modelPerfil = new Application_Model_Perfil();
        $rsPerfil = $modelPerfil->fetchAll();

        $paginator = Zend_Paginator::factory($rsPerfil);
        $paginator->setCurrentPageNumber($page)
        ->setItemCountPerPage(10);
        
        Zend_Paginator::setDefaultScrollingStyle('Sliding');
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagination.phtml');
        
        $this->view->assign('paginator', $paginator);
        
//     //instanciar a model. 
//         $modelPerfil = new Application_Model_Perfil();
//         //passar variavel para a camada view.
//         $rowSet = $modelPerfil->fetchAll();
//         $this->view->dados = $rowSet;
    }
    
    public function formularioAction()
    {
        
        $dados = $this->_getAllParams();
        $mPerfil = new Application_Model_Perfil();
        if(!empty($dados['id_perfil'])){
        $row = $mPerfil->fetchRow("id_perfil = ".$dados['id_perfil']);
        }else{
            $row = $mPerfil->createRow();
        }
        $this->view->row = $row;
    }
    
    public function gravarAction()
    {
        $dados = $this->_getAllParams();
        $mPerfil = new Application_Model_Perfil();
        $mPerfil->gravar($dados);
         $this->redirect("perfil/index");
    }
    
    public function excluirAction()
    {
        $dados = $this->_getParam('id_perfil');
        $mPerfil = new Application_Model_Perfil();
        $mPerfil->excluir($dados);
        $this->redirect("perfil/index");
    }
    
}

