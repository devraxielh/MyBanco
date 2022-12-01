<?php
include_once BASE_URL."/Conexion/Conexion.php";
include_once "Usuario.php";

class Cliente extends Conexion
{
    public $correo;
    public $cedula;
    public $nombre;
    public $edad;
    public $usuario;

    public function create()
    {
        $this->conectar();
        $user = new Usuario();
        $user->correo = $this->correo;
        $user->cedula = $this->cedula;
        $user->rol = 1;
        $user = $user->create();
        $alert = new stdClass();
        if($user->status=='success'){
            $pre = mysqli_prepare($this->con,"INSERT INTO `clientes`(`correo`, `cedula`, `nombre`, `edad`, `usuario`) VALUES (?,?,?,?,?)");
            $pre->bind_param('sssii',$this->correo,$this->cedula,$this->nombre,$this->edad,$user->data);
            $pre->execute();
            if ($pre->error)
            {
                $alert->msj = $pre->error;
                $alert->data = 0;
                $alert->status = 'danger';
            }else{
                $alert->msj = "Datos Guardados...";
                $alert->data = $pre->insert_id;
                $alert->status = 'success';
                return $alert;
            }
        }
        else
        {
            $alert->msj = "Error creando usuario ".$user->msj;
            $alert->data = 0;
            $alert->status = 'danger';
        }
        return $alert;

    }
}