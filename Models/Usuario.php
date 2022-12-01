<?php
include_once BASE_URL."/Conexion/Conexion.php";

class Usuario extends Conexion
{
    public $usuario;
    public $password;
    public $rol;
    public function create()
    {
        $this->conectar();
        $cedula = sha1($this->cedula);
        $pre = mysqli_prepare($this->con,"INSERT INTO `usuarios`(`usuario`, `password`, `rol`) VALUES (?,?,?)");
        $pre->bind_param('ssi',$this->correo,$cedula,$this->rol);
        $pre->execute();
        $alert = new stdClass();
        if ($pre->error)
        {
            $alert->msj = $pre->error;
            $alert->data = 0;
            $alert->status = 'danger';
        }else
        {
            $alert->msj = "Datos Guardados...";
            $alert->data = $pre->insert_id;
            $alert->status = 'success';
        }
        return $alert;



    }
}