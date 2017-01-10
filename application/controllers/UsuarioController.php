<?php

class UsuarioController extends Zend_Controller_Action
{

    public function indexAction()
    {
    
        $page = $this->_getParam('page', 1);
    
        $modelUsuario = new Application_Model_Usuario();
        $rsUsuario =  $modelUsuario->fetchAll();
    
        $paginator = Zend_Paginator::factory($rsUsuario);
        $paginator->setCurrentPageNumber($page)->setItemCountPerPage(10);
    
        Zend_Paginator::setDefaultScrollingStyle('Sliding');
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagination.phtml');
    
        $this->view->assign('paginator', $paginator);
    }
    
    public function loginAction()
    {
        
    }
    
    public function verificarEmailAction()
    {
        $this->_helper->layout->disableLayout();
        
        $email = $this->_getParam('email');
        
        $mUsuario = new Application_Model_Usuario();
        $rsUsuario = $mUsuario->fetchRow("email = '$email'");
        
        if(!$rsUsuario){
            echo false;die;
        }
        echo true; die;
    } 
   
    public function autenticarAction()
    {
        $dados = $this->_getAllParams();
        
        $mUsuario = new Application_Model_Usuario();
        
        $rsUsuario = $mUsuario->fetchRow("email ='".$dados['email']."'AND senha = '".md5($dados['senha'])."'");
        
        if($rsUsuario != null){
            $_SESSION['id_usuario'] = $rsUsuario['id_usuario'];
            $_SESSION['nome'] = $rsUsuario['nome'];
            $_SESSION['perfil'] = $rsUsuario['id_perfil'];
            
            $this->redirect("usuario/index");
        }
        $_SESSION['mensagem'] ="E-mail ou senha inválidos";
        $this->redirect("usuario/login");
        
    }
    
    public function logoutAction(){
           session_destroy();
           echo $this->redirect("usuario/login");
           die;
    }
    
    public function formularioAction()
    {   
        $dados = $this->_getAllParams();
        $modelUsuario = new Application_Model_Usuario();
        $mUf = new Application_Model_Uf();
        
        $mPerfil = new Application_Model_Perfil();
        if(!empty($dados['id_usuario'])){
            $row = $modelUsuario->fetchRow("id_usuario = ".$dados['id_usuario']);
        }else{
            $row = $modelUsuario->createRow();
        }
        $this->view->uf = $mUf->fetchAll();
        
        $mMunicipio = new Application_Model_Municipio();
        $this->view->municipio = $mMunicipio->fetchAll("id_uf = '{$row->id_uf}'",'nome');
        $this->view->perfis = $mPerfil->fetchAll();
        $this->view->row = $row;
    }
    
    public function uploadFoto($id_usuario){

        
        if(isset($_FILES['foto']) && $_FILES['foto']['error'] == 0){//verifica se o campo files com name foto está settado
            //dê um print_ na constante FILES para ver todos os parâmetros que ela possui sobre o arquivo
            if($_files['foto']['size'] > 20000){
                return false;
            }
            $origem = $_FILES['foto']['tmp_name']; // pega o endereço temporário onde a imagem é guardada até que seja feito o upload
            $extensao = substr($_FILES['foto']['name'], strrpos($_FILES['foto']['name'], '.')); //recupera qual a extenção do arquivo (jpg,pdf,etc)
            $destino = 'img/fotos/' . $id_usuario . $extensao; //informa a pasta destino juntamene com o novo nome do arqui
            move_uploaded_file($origem, $destino); //método do ZF para fazer o upload do arquivo: parâmetros: origem e destino
            return $id_usuario.$extensao; //
            
        }
    }
    
    public function gravarAction()
    {
        $dados = $this->_getAllParams();
        $dados['senha'] = md5($dados['senha']);
        $modelUsuario = new Application_Model_Usuario();
        $id_usuario = $modelUsuario->gravar($dados);
        
        $foto = $this->uploadFoto($id_usuario);
        $dadosUpdate['foto'] = $foto;
        $modelUsuario->update($dadosUpdate,"id_usuario = $id_usuario");
        $this->redirect("usuario/index");
    }
    
    public function excluirAction()
    {
        $dados = $this->_getParam('id_usuario');
        $modelUsuario = new Application_Model_Usuario();
        $modelUsuario->excluir($dados);
        $this->redirect("usuario/index");
    }
        

}
?>
