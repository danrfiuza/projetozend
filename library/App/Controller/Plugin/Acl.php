<?php
class App_Controller_Plugin_Acl extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        
        $paginasPublicas = array(
            'usuario/login',
            'usuario/autenticar',
            'usuario/logout',
            'error/error',
        );
        
        $perfilAdministrador = array(
            'usuario/index',
            'usuario/formulario',
            'usuario/gravar',
            'usuario/excluir',
            'municipio/carregar-municipio',
            'perfil/index',
            'perfil/formulario',
            'perfil/gravar',
            'perfil/excluir',
            
        );

        $perfilColaborador = array(
            'usuario/index',
            'perfil/index',
        );

        $controller = $request->getControllerName();
        $action     = $request->getActionName();

        $url = $controller."/".$action;
        
        if(in_array($url,$paginasPublicas)){
            return true;
        }

        if(!empty($_SESSION['id_usuario'])){
             
            if($_SESSION['perfil'] == 1 && in_array($url,$perfilAdministrador)){
                return true;
            }

            if($_SESSION['perfil'] == 3 && in_array($url,$perfilColaborador)){
                return true;
            }
        }

        $request->setControllerName('error');
        $request->setActionName('acesso-negado');
    }
}