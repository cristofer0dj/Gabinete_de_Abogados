<?php
namespace App\Controllers;
 
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\taller\ClienteModel;
use App\Models\taller\VehiculoModel;
use App\Models\taller\MecanicoModel;
use App\Models\taller\ServicioModel;


class ApiTaller extends ResourceController
{
    use ResponseTrait;
    // listar alumnos
    public function index()
    {       
        $model = new ClienteModel();
        $data = $model->findAll();
        return $this->respond($data, 200);
    }

    //nuevo cliente
    public function nuevo()
    {        
        $model = new ClienteModel();
         $datos = $this->request->getJSON(); 
        $data = [  
            'nombre' => $datos->nombre,
            'apellido' => $datos->apellido,
            'email' => $datos->email, 
            'telefono' => $datos->telefono,          
        ];  
       
        $model->insert($data);
        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
                'success' => 'Datos Guardados con exito'
            ]
        ];
         
        return $this->respondCreated($data, 201);
    }

   // listar vehiculos
    public function vehiculos()
    {       
        $model = new VehiculoModel();
        $data = $model->VerVehiculos();
        return $this->respond($data, 200);
    }

  //nuevo vehiculo
    public function nuevovehiculo()
    {        
        $model = new VehiculoModel();
        $datos = $this->request->getJSON(); 
        $data = [  
            'marca' => $datos->marca,
            'modelo' => $datos->modelo,
            'anho' => $datos->anho, 
            'id_cliente' => $datos->id_cliente,          
        ];  
       
        $model->insert($data);
        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
                'success' => 'Datos Guardados con exito'
            ]
        ];
         
        return $this->respondCreated($data, 201);
    }
    
     // listar servicios
    public function servicios()
    {       
        $model = new ServicioModel();
        $data = $model->VerServicios();
        return $this->respond($data, 200);
    }

    //nuevo servicio
    public function nuevoservicio()
    {        
        $model = new ServicioModel();
        $datos = $this->request->getJSON(); 
        $data = [  
            'costo' => $datos->costo,
            'descripcion' => $datos->descripcion,
            'estado' => $datos->estado, 
            'fecha_ingreso' => $datos->fechaingreso, 
            'id_vehiculo' => $datos->idvehiculo, 
            'id_mecanico' => $datos->idmecanico,          
        ];  
       
        $model->insert($data);
        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
                'success' => 'Datos Guardados con exito'
            ]
        ];
         
        return $this->respondCreated($data, 201);
    }
}