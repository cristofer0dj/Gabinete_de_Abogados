<?php
namespace App\Controllers;
 
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\club\SocioModel;
use App\Models\club\BarcoModel;
use App\Models\club\CapitanModel;
use App\Models\club\SalidaModel;


class ApiClub extends ResourceController
{
    use ResponseTrait;
    // listar alumnos
    public function index()
    {       
        $model = new SocioModel();
        $data = $model->findAll();
        return $this->respond($data, 200);
    }

    //nuevo cliente
    public function nuevo()
    {        
        $model = new SocioModel();
        $datos = $this->request->getJSON(); 
        $data = [  
            'nombre' => $datos->nombre,
            'apellido' => $datos->apellido,
            'telefono' => $datos->telefono,
            'email' => $datos->email,           
        ]; 
      
        $model->insert($data);
        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
                'success' => 'Datos Guardados con exito'
            ]
        ];
         
        return $this->respondCreated($response, 201);
    }

   // listar habitaciones
    public function barcos()
    {       
        $model = new BarcoModel();
        $data = $model->findAll();
        return $this->respond($data, 200);
    }

  //nuevo vehiculo
    public function barconuevo()
    {        
        $model = new BarcoModel();
        $datos = $this->request->getJSON(); 
        $data = [  
            'id_socio' => $datos->idsocio,
            'matricula' => $datos->matricula,
            'nombre' => $datos->nombre,
            'numero_amarre' => $datos->numeroamarre,
            'cuota' => $datos->cuota,            
        ]; 
       
        $model->insert($data);
        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
                'success' => 'Datos Guardados con exito'
            ]
        ];
         
        return $this->respondCreated($response, 201);
    }
    
     // listar servicios
    public function salidas()
    {       
        $model = new SalidaModel();       
        $data = $model->VerSalidas();       
        return $this->respond($respuesta, 200);
    }

    //nuevo servicio
    public function salidanueva()
    {        
        $model = new SalidaModel();
        $datos = $this->request->getJSON(); 
        $data = [  
            'id_barco' => $datos->idbarco,
            'id_capitan' => $datos->idcapitan,
            'fecha_salida' => $datos->fechasalida,
            'hora_salida' => $datos->horasalida,
            'destino' => $datos->destino,            
        ]; 
        
        $model->insert($data);
        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
                'success' => 'Datos Guardados con exito'
            ]
        ];
         
        return $this->respondCreated($response, 201);
    }
}