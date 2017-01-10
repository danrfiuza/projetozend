<?php
class Application_Model_Perfil extends Zend_Db_Table
    
{
    protected $_name = 'perfil'; 
    
    public function gravar($dados)
    {
        if(!empty($dados['id_perfil'])){
            $row = $this->fetchRow("id_perfil = ".$dados['id_perfil']);
        }else{
            $row = $this->createRow();
        }
        $row->setFromArray($dados);
        $row->save();

    }
    
    public function excluir($dados)
    {
            $row = $this->fetchRow('id_perfil = '.$dados['id_perfil']);
            $row->delete();
    }
    
}

