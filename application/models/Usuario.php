<?php
class Application_Model_Usuario extends Zend_Db_Table
    
{
    protected $_name = 'usuario'; 
    
    public function gravar($dados)
    {
        if(!empty($dados['id_usuario'])){
            $row = $this->fetchRow("id_usuario = ".$dados['id_usuario']);
        }else{
            $row = $this->createRow();
        }
        $row->setFromArray($dados);
        return $row->save();
    
    }
    
    public function excluir($dados)
    {
        $row = $this->fetchRow('id_usuario = '.$dados['id_usuario']);
        $row->delete();
    }
    
}

